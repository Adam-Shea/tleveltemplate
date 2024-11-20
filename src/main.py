import sqlite3
import json
from flask import (
    Flask,
    jsonify,
    request
)

flask_app = Flask(__name__)
database_url = "t_level_db.db"


# Basic hello world
# http://127.0.0.1:5000
@flask_app.route("/")  # Route
def hello_world():
    return "<p>Hello, World!</p>"  # Response


# Return whole table
# http://127.0.0.1:5000/sql
@flask_app.route("/sql")
def sql_example():
    sql_connection = sqlite3.connect(database_url)
    sql_cursor = sql_connection.cursor()
    response = sql_cursor.execute("SELECT * FROM example_table").fetchall()
    sql_connection.close()
    return response


# Return whole table as json
# http://127.0.0.1:5000/sql/json
@flask_app.route("/sql/json")
def sql_example_json():
    sql_connection = sqlite3.connect(database_url)
    sql_cursor = sql_connection.cursor()
    response = sql_cursor.execute(
        """
        SELECT json_group_object(
            id,
            json_object('Name',name)
        ) as result FROM example_table
        """).fetchone()
    sql_connection.close()
    return jsonify(response)


# Return a single row from the table by id
# http://127.0.0.1:5000/sql/json/1
@flask_app.route("/sql/json/<id>")
def sql_example_json_id(id):
    sql_connection = sqlite3.connect(database_url)
    sql_cursor = sql_connection.cursor()
    response = sql_cursor.execute(
        """
        SELECT json_group_object(
            id,
            json_object('Name',name)
        ) as result
        FROM example_table
        WHERE id='%s'
        """ % (id)).fetchone()
    sql_connection.close()
    return jsonify(response)
