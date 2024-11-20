from flask import Flask

app = Flask(__name__)

@app.route("/") # Route
def hello_world():
    return "<p>Hello, World!</p>" # Response

@app.route("/sql")
def sql_example():
    return "<p>Hello, World!</p>"
