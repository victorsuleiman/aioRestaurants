from dotenv import load_dotenv
import os
from flask import Flask, render_template,  request, escape
from flask_pymongo import PyMongo
from flask_socketio import SocketIO, emit
from bson.json_util import dumps, loads 
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

    updateInventory(data['dishes'])

    receipt = {'server' : server , 'employeeId' : employeeId, 'dishes' : dishes, 'taxes' : taxes, 'total' : total, 
        'paymentType' : paymentType, 'date' : date}
    
    # mongo.db.receipt.insert_one(receipt)

def updateInventory(dishes):
    print(f"Updating inventory qty's for dishes {dishes} in receipt")

    for dish in dishes:
        ingredients = mongo.db.dish.find_one({'name' : dish})['ingredients']
        for ingredient in ingredients:
            name = ingredient['name']
            qty = ingredient['qty']

            mongo.db.productInventory.update_one(
                {'productName':name},
                {
                    '$inc' : {'qty' : -qty}
                }
            )
    
    print("done.")


# f = open('mockReceipt.json')
# data = json.load(f)
# submitReceipt(data)


if __name__ == '__main__':
    socketio.run(app,host = '0.0.0.0')

