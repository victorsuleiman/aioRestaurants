from flask import Flask, render_template,  request, escape
from flask_pymongo import PyMongo
from dotenv import load_dotenv
import os

class bcolors:
    HEADER = '\033[95m'
    OKBLUE = '\033[94m'
    OKCYAN = '\033[96m'
    OKGREEN = '\033[92m'
    WARNING = '\033[93m'
    FAIL = '\033[91m'
    ENDC = '\033[0m'
    

load_dotenv()

app = Flask(__name__)
app.config["MONGO_URI"] = os.getenv('MONGO_URI')
mongo = PyMongo(app)

def getProducts():
    products = list()

    productQuery = mongo.db.productInventory.find({})

    for p in productQuery:
        products.append(p['productName'])

    return products

def getDishes():
    return mongo.db.dish.find({})


def mainTest():

    products = getProducts()

    for dish in getDishes():
        print(f"Checking ingredient matches for dish {dish['name']} ")
        for ingredient in dish['ingredients']:
            
            if products.count(ingredient['name']) == 1:
                print (f"Ingredient {ingredient['name']} : Passed!")
            else: 
                print (f"{bcolors.FAIL}Ingredient {ingredient['name']} : Not Passed.{bcolors.ENDC}")
        print("---------------------------------------------------------------------------------------------")

mainTest()

