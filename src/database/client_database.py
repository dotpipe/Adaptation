import sqlite3
from datetime import datetime, timedelta

DB_NAME = 'adapt_client.db'

def get_db_connection():
    return sqlite3.connect(DB_NAME)

def init_client_db():
    conn = get_db_connection()
    c = conn.cursor()

    # Create SHOPPING_LIST table
    c.execute('''CREATE TABLE IF NOT EXISTS SHOPPING_LIST
                 (id INTEGER PRIMARY KEY AUTOINCREMENT,
                 item_name TEXT NOT NULL,
                 quantity INTEGER,
                 added_date TIMESTAMP)''')

    # Create TODOS table
    c.execute('''CREATE TABLE IF NOT EXISTS TODOS
                 (id INTEGER PRIMARY KEY AUTOINCREMENT,
                 task TEXT NOT NULL,
                 due_date TIMESTAMP,
                 completed INTEGER)''')

    # Create HABITS table
    c.execute('''CREATE TABLE IF NOT EXISTS HABITS
                 (id INTEGER PRIMARY KEY AUTOINCREMENT,
                 habit_name TEXT NOT NULL,
                 frequency TEXT,
                 last_completed TIMESTAMP)''')

    # Create CONFIG table
    c.execute('''CREATE TABLE IF NOT EXISTS CONFIG
                 (key TEXT PRIMARY KEY,
                 value TEXT,
                 last_updated TIMESTAMP)''')

    # Create HOTLISTS table
    c.execute('''CREATE TABLE IF NOT EXISTS HOTLISTS
                 (id INTEGER PRIMARY KEY AUTOINCREMENT,
                 item TEXT)''')

    conn.commit()
    conn.close()

def add_shopping_item(item_name, quantity):
    conn = get_db_connection()
    c = conn.cursor()
    c.execute("INSERT INTO SHOPPING_LIST (item_name, quantity, added_date) VALUES (?, ?, ?)",
              (item_name, quantity, datetime.now()))
    conn.commit()
    conn.close()

def add_todo(task, due_date):
    conn = get_db_connection()
    c = conn.cursor()
    c.execute("INSERT INTO TODOS (task, due_date, completed) VALUES (?, ?, 0)",
              (task, due_date))
    conn.commit()
    conn.close()

def add_habit(habit_name, frequency):
    conn = get_db_connection()
    c = conn.cursor()
    c.execute("INSERT INTO HABITS (habit_name, frequency) VALUES (?, ?)",
              (habit_name, frequency))
    conn.commit()
    conn.close()

def update_config(key, value):
    conn = get_db_connection()
    c = conn.cursor()
    c.execute("INSERT OR REPLACE INTO CONFIG (key, value, last_updated) VALUES (?, ?, ?)",
              (key, value, datetime.now()))
    conn.commit()
    conn.close()

def get_config(key):
    conn = get_db_connection()
    c = conn.cursor()
    c.execute("SELECT value FROM CONFIG WHERE key = ?", (key,))
    result = c.fetchone()
    conn.close()
    return result[0] if result else None

def add_to_hotlist(item):
    conn = get_db_connection()
    c = conn.cursor()
    c.execute("INSERT INTO HOTLISTS (item) VALUES (?)", (item,))
    conn.commit()
    conn.close()

init_client_db()