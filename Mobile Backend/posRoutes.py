from flask import Flask, render_template,  request, escape
from flask_pymongo import PyMongo
from dotenv import load_dotenv
import os

load_dotenv()

app = Flask(__name__)
app.config["MONGO_URI"] = os.getenv('MONGO_URI') # replace the URI with your own connection
mongo = PyMongo(app)

# @app.route('/')
# def init():                            # this is a comment. You can create your own function name
#     return '<h1> {} </h1>'.format(__name__)

def getDishes():
    return mongo.db.dish.find({}).limit(1)

dishes = list(getDishes())
print(dishes[0]['ingredients'][6]['name'])

# if __name__ == '__main__':
#     app.run(host='0.0.0.0',debug=True)

