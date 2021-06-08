from flask import Flask, render_template,  request, escape
from flask_pymongo import PyMongo
from flask_socketio import SocketIO, emit
from dotenv import load_dotenv
import os
import json

load_dotenv()

app = Flask(__name__)
app.config["MONGO_URI"] = os.getenv('MONGO_URI')
mongo = PyMongo(app)

socketio = SocketIO(app)

@app.route('/')
def init():                            
    return '<h1> {} </h1>'.format(__name__)

def getProducts():
    products = list()

    productQuery = mongo.db.productInventory.find({})

    for p in productQuery:
        products.append(p['productName'])

    return products

def getDishes():
    return mongo.db.dish.find({}).limit(1)

# @socketio.on('submitReceipt')
def submitReceipt(data):
    server = data['server']
    employeeId = data['employeeId']
    dishes = data['dishes']
    taxes = data['taxes']
    total = data['total']
    paymentType = data['paymentType']
    date = data['date']

    receipt = {'server' : server , 'employeeId' : employeeId, 'dishes' : dishes, 'taxes' : taxes, 'total' : total, 
        'paymentType' : paymentType, 'date' : date}
    
    mongo.db.receipt.insert_one(receipt)

f = open('mockReceipt.json')
data = json.load(f)
submitReceipt(data)
print("receipt submitted.")


# if __name__ == '__main__':
#     app.run(host='0.0.0.0',debug=True)

