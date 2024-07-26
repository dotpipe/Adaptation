import sqlite3
import requests
from datetime import datetime, timedelta

class CartManager:
    def __init__(self, local_db_path, cloud_api_url):
        self.local_db = sqlite3.connect(local_db_path)
        self.cloud_api_url = cloud_api_url
        self.last_sync = datetime.now()
        self.create_table()

    def create_table(self):
        cursor = self.local_db.cursor()
        cursor.execute('''
            CREATE TABLE IF NOT EXISTS cart
            (id INTEGER PRIMARY KEY, item_name TEXT, quantity INTEGER, received INTEGER)
        ''')
        self.local_db.commit()

    def add_to_cart(self, item):
        cursor = self.local_db.cursor()
        cursor.execute("INSERT INTO cart (item_name, quantity, received) VALUES (?, ?, ?)",
                       (item['name'], item['quantity'], 0))
        self.local_db.commit()
        self.schedule_sync()

    def remove_from_cart(self, item_id):
        cursor = self.local_db.cursor()
        cursor.execute("DELETE FROM cart WHERE id = ?", (item_id,))
        self.local_db.commit()
        self.schedule_sync()

    def get_cart(self):
        cursor = self.local_db.cursor()
        cursor.execute("SELECT * FROM cart")
        return cursor.fetchall()

    def sync_with_cloud(self):
        cart_data = self.get_cart()
        response = requests.post(self.cloud_api_url, json=cart_data)
        if response.status_code == 200:
            self.last_sync = datetime.now()
        else:
            print("Sync failed. Status code:", response.status_code)

    def schedule_sync(self):
        current_time = datetime.now()
        if (current_time - self.last_sync) > timedelta(hours=3):
            self.sync_with_cloud()

    def manual_update(self):
        self.sync_with_cloud()

    def mark_as_received(self, item_id):
        cursor = self.local_db.cursor()
        cursor.execute("UPDATE cart SET received = 1 WHERE id = ?", (item_id,))
        self.local_db.commit()
        self.schedule_sync()

# Usage in mobile app (React Native)
cart_manager = CartManager('adapt.db', 'https://api.adapt.com/cart')

# Usage in desktop app (Tkinter)
cart_manager = CartManager('adapt.db', 'https://api.adapt.com/cart')