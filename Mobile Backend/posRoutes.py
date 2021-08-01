
import os
from flask import Flask, render_template,  request, escape
from flask_pymongo import PyMongo
from flask_socketio import SocketIO, emit
from bson.json_util import dumps, loads 
from dotenv import load_dotenv
import json

load_dotenv()

app = Flask(__name__)
app.config["MONGO_URI"] = os.getenv('MONGO_URI')
app.config['DEBUG'] = True
mongo = PyMongo(app)

socketio = SocketIO(app)

@app.route('/')
def init():                            
    return '<h1> {} </h1>'.format(__name__)

def getDishes():
    return mongo.db.dish.find({})

@socketio.on('updatePosDatabase')
def updatePosDatabase():
    dishes = list(mongo.db.dish.find({}))
    employees = list(mongo.db.employee.find({}))
    restaurants = list(mongo.db.restaurant.find({}))
    userCategories = list(mongo.db.userCategory.find({}))
    goals = list(mongo.db.goal.find({}))

    json_dishes = dumps(dishes)
    json_employees = dumps(employees)
    json_restaurants = dumps(restaurants)
    json_userCategories = dumps(userCategories)
    json_goals = dumps(goals)
    
    emit('onGetDishes',json_dishes)
    emit('onGetEmployees',json_employees)
    emit('onGetRestaurants',json_restaurants)
    emit('onGetUserCategories',json_userCategories)
    emit('onGetGoals',json_goals)

@socketio.on('authenticateUser')
def fetchUsername(data):
    username = data['username']
    print("Looking for username {} to login".format(username))
    usernameToFind = mongo.db.employee.find_one({'username':username})

    if usernameToFind == None:
        print("Username not found.")
        # emit('usernameSearchResult',False)
    else:
        print("Username found.")
        # json_data = dumps(usernameToFind)
        # emit('usernameSearchForLogin', json_data)


@socketio.on('submitReceipt')
def submitReceipt(data):
    server = data['server']
    employeeId = data['employeeId']
    dishes = data['dishes']
    taxes = data['taxes']
    total = data['total']
    paymentType = data['paymentType']
    date = data['date']

    updateSales(date,total)

    updateInventory(data['dishes'])

    if (paymentType == "cash"):
        updateCashFund(total)

    receipt = {'server' : server , 'employeeId' : employeeId, 'dishes' : dishes, 
        'taxes' : taxes, 'total' : total, 'paymentType' : paymentType, 'date' : date}
    
    mongo.db.receipt.insert_one(receipt)
    print("receipt successfully inserted.")

def updateInventory(dishes):
    print(f"Updating inventory qty's for dishes {dishes} in receipt")

    for dish in dishes:
        dishQty = dish['qty']
        ingredients = mongo.db.dish.find_one({'name' : dish['name']})['ingredients']
        for ingredient in ingredients:
            name = ingredient['name']
            qty = ingredient['qty']

            mongo.db.productInventory.update_one(
                {'productName':name},
                {
                    '$inc' : {'qty' : -dishQty * qty}
                }
            )
    
    print("done.")

def updateSales(date, amount):
    sales = mongo.db.goal.find_one({'date': date})
    print(f"incrementing sales for date {date}...")
    if sales == None:
        print("sales not found for this date.")
    else:
        print("sales found for this date. Incrementing...")
        mongo.db.goal.update_one(
            {'date' : date},
            {
                '$inc' : {'sales' : amount}
            }
        )
        print("done.")

@socketio.on('submitGoal')
def submitGoal(data):
    
    date = data['date']
    dayGoal = data['goal']
    sales = data['sales']

    print(f"inserting new goal for date {date}...")

    goal = {'date' : date, 'goal' : dayGoal, 'sales' : sales}

    mongo.db.goal.insert_one(goal)
    print("done.")

@socketio.on('updateGoal')
def updateGoal(data):
    date = data['date']
    dayGoal = data['goal']

    print(f"Updating goal for date {date}...")

    mongo.db.goal.update_one(
            {'date' : date},
            {
                '$set' : {'goal' : dayGoal}
            }
        )

def updateCashFund(qty):
    print("Payment in cash. Updating cash fund...")
    mongo.db.restaurant.update_one(
            {'name' : "Franchise 1"},
            {
                '$inc' : {'cashFund' : qty}
            }
        )

if __name__ == '__main__':
    socketio.run(app,host = '0.0.0.0')

