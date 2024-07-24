import tkinter as tk
from tkinter import ttk, simpledialog, messagebox
import sqlite3
from functools import lru_cache
from datetime import datetime, timedelta

class AdaptGUI:
    def __init__(self, master):
        self.master = master
        master.title("Adapt Shopping System")
        self.init_ui()
        self.cache_data()

    def init_ui(self):
        self.notebook = ttk.Notebook(self.master)
        self.notebook.pack(fill=tk.BOTH, expand=True)

        self.deals_frame = ttk.Frame(self.notebook)
        self.order_frame = ttk.Frame(self.notebook)
        self.preorder_frame = ttk.Frame(self.notebook)
        self.reserve_frame = ttk.Frame(self.notebook)
        self.hold_frame = ttk.Frame(self.notebook)

        self.notebook.add(self.deals_frame, text="Deals")
        self.notebook.add(self.order_frame, text="Order")
        self.notebook.add(self.preorder_frame, text="Preorder")
        self.notebook.add(self.reserve_frame, text="Reserve")
        self.notebook.add(self.hold_frame, text="Hold")

        self.init_all_tabs()

    @lru_cache(maxsize=None)
    def cache_data(self):
        self.all_products = self.fetch_all_products()
        self.all_deals = self.fetch_all_deals()

    def init_all_tabs(self):
        self.init_deals_tab()
        self.init_order_tab()
        self.init_preorder_tab()
        self.init_reserve_tab()
        self.init_hold_tab()

    def create_scrollable_frame(self, parent):
        canvas = tk.Canvas(parent)
        scrollbar = ttk.Scrollbar(parent, orient="vertical", command=canvas.yview)
        scrollable_frame = ttk.Frame(canvas)

        scrollable_frame.bind(
            "<Configure>",
            lambda e: canvas.configure(scrollregion=canvas.bbox("all"))
        )

        canvas.create_window((0, 0), window=scrollable_frame, anchor="nw")
        canvas.configure(yscrollcommand=scrollbar.set)

        canvas.pack(side="left", fill="both", expand=True)
        scrollbar.pack(side="right", fill="y")

        return scrollable_frame

    def init_deals_tab(self):
        scrollable_frame = self.create_scrollable_frame(self.deals_frame)
        for deal in self.all_deals:
            self.create_deal_widget(scrollable_frame, deal)

    def init_order_tab(self):
        scrollable_frame = self.create_scrollable_frame(self.order_frame)
        for product in self.all_products:
            self.create_product_widget(scrollable_frame, product, "Order")

    def init_preorder_tab(self):
        scrollable_frame = self.create_scrollable_frame(self.preorder_frame)
        for product in self.all_products:
            if product['ACTION'] == 0:
                self.create_product_widget(scrollable_frame, product, "Preorder")

    def init_reserve_tab(self):
        scrollable_frame = self.create_scrollable_frame(self.reserve_frame)
        for product in self.all_products:
            if product['ACTION'] == 0 and product['QUANTITY'] > 0:
                self.create_product_widget(scrollable_frame, product, "Reserve")

    def init_hold_tab(self):
        scrollable_frame = self.create_scrollable_frame(self.hold_frame)
        for product in self.all_products:
            if product['ACTION'] == 0 and product['QUANTITY'] > 0:
                self.create_product_widget(scrollable_frame, product, "Hold")

    def create_deal_widget(self, parent, deal):
        deal_frame = ttk.Frame(parent)
        deal_frame.pack(pady=5, padx=10, fill="x")
        ttk.Label(deal_frame, text=deal['STORE_NAME'], font=('Helvetica', 10, 'bold')).pack(side="left")
        ttk.Label(deal_frame, text=deal['SLOGAN']).pack(side="left", padx=10)
        ttk.Button(deal_frame, text="View", command=lambda: self.view_deal(deal)).pack(side="right")

    def create_product_widget(self, parent, product, action):
        product_frame = ttk.Frame(parent)
        product_frame.pack(pady=5, padx=10, fill="x")
        ttk.Label(product_frame, text=product['PRODUCT'], font=('Helvetica', 10, 'bold')).pack(side="left")
        ttk.Label(product_frame, text=f"${product['INDV_PRICE']:.2f}").pack(side="left", padx=10)
        ttk.Button(product_frame, text=action, command=lambda: self.handle_action(action, product)).pack(side="right")

    def handle_action(self, action, product):
        if action == "Order":
            self.order_item(product)
        elif action == "Preorder":
            self.preorder_item(product)
        elif action == "Reserve":
            self.reserve_item(product)
        elif action == "Hold":
            self.hold_item(product)

    def fetch_all_products(self):
        with sqlite3.connect('adapt.db') as conn:
            cursor = conn.cursor()
            cursor.execute("SELECT * FROM PREORDERS")
            return [dict(zip([column[0] for column in cursor.description], row)) for row in cursor.fetchall()]

    def fetch_all_deals(self):
        with sqlite3.connect('adapt.db') as conn:
            cursor = conn.cursor()
            cursor.execute("SELECT * FROM ADVS WHERE START <= datetime('now') AND END >= datetime('now')")
            return [dict(zip([column[0] for column in cursor.description], row)) for row in cursor.fetchall()]

    # Implement order_item, preorder_item, reserve_item, hold_item, and view_deal methods here

root = tk.Tk()
gui = AdaptGUI(root)
root.mainloop()