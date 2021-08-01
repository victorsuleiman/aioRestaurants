from flask import Flask, render_template,  request, escape
from flask_pymongo import PyMongo
from dotenv import load_dotenv
import os

load_dotenv()

app = Flask(__name__)
app.config["MONGO_URI"] = os.getenv('MONGO_URI')
mongo = PyMongo(app)

collections = ["counter","dish","employee","goal","order","productInventory","receipt","restaurant","shipper","supplier",
    "userCategory"]
createdCollections = mongo.db.list_collection_names()

print ("Creating necessary collections for the central database.")
print ("You can insert data into the collections using the web application or manually using MongoDB Atlas.")
print ("For the latter, remember to stick to the proper data structures!")

for collection in collections:
    if collection in createdCollections:
        print (f"Collection {collection} already exists.")
    else:
        print (f"Creating collection {collection}...")
        mongo.db.create_collection(collection)

print("done.")