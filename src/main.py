import sqlite3
from flask import Flask

flask_app = Flask(__name__)
sql_connection = sqlite3.connect("")


@flask_app.route("/")  # Route
def hello_world():
    return "<p>Hello, World!</p>"  # Response


@flask_app.route("/sql")
def sql_example():
    return "<p>Hello, World!</p>"
