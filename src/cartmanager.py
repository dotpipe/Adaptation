import sqlite3
import requests
from datetime import datetime, timedelta

class CartManager:
    def __init__(self, local_db_path, cloud_api_url):
        self.local_db = sqlite3.connect(local_db_path)
        self.cloud_api_url = cloud_api_url
        self.last_sync = datetime.now()

    def add_to_cart(self, item):
        # Add item to local database
        # Schedule sync if needed

    def remove_from_cart(self, item_id):
        # Remove item from local database
        # Schedule sync if needed

    def get_cart(self):
        # Retrieve cart from local database

    def sync_with_cloud(self):
        # Sync local changes with cloud database
        # Update last_sync timestamp

    def schedule_sync(self):
        # Schedule next sync based on 3-hour intervals

    def manual_update(self):
        # Force immediate sync with cloud

    def mark_as_received(self, item_id):
        # Mark item as received in local database
        # Schedule sync if needed

# Usage in mobile app (React Native)
cart_manager = CartManager('adapt.db', 'https://api.adapt.com/cart')

# Usage in desktop app (Tkinter)
cart_manager = CartManager('adapt.db', 'https://api.adapt.com/cart')