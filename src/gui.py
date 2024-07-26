import tkinter as tk
from tkinter import ttk, messagebox
from src.cartmanager import CartManager
from src.chatbot import get_bot_response

class AdaptApp:
    def __init__(self, master):
        self.master = master
        self.master.title("Adapt Shopping Assistant")
        self.cart_manager = CartManager('adapt.db', 'https://api.adapt.com/cart')
        
        self.create_widgets()

    def create_widgets(self):
        # Create a notebook for tabbed interface
        self.notebook = ttk.Notebook(self.master)
        self.notebook.pack(expand=True, fill='both')

        # Cart Tab
        self.cart_frame = ttk.Frame(self.notebook)
        self.notebook.add(self.cart_frame, text='Cart')
        self.create_cart_widgets()

        # Chat Tab
        self.chat_frame = ttk.Frame(self.notebook)
        self.notebook.add(self.chat_frame, text='Support Chat')
        self.create_chat_widgets()

        # Settings Tab
        self.settings_frame = ttk.Frame(self.notebook)
        self.notebook.add(self.settings_frame, text='Settings')
        self.create_settings_widgets()

    def create_cart_widgets(self):
        # Add to Cart
        ttk.Button(self.cart_frame, text="Add Item", command=self.add_item).pack(pady=5)
        
        # View Cart
        ttk.Button(self.cart_frame, text="View Cart", command=self.view_cart).pack(pady=5)
        
        # Remove from Cart
        ttk.Button(self.cart_frame, text="Remove Item", command=self.remove_item).pack(pady=5)
        
        # Mark as Received
        ttk.Button(self.cart_frame, text="Mark as Received", command=self.mark_received).pack(pady=5)
        
        # Manual Sync
        ttk.Button(self.cart_frame, text="Manual Sync", command=self.manual_sync).pack(pady=5)

    def create_chat_widgets(self):
        self.chat_log = tk.Text(self.chat_frame, state='disabled')
        self.chat_log.pack(expand=True, fill='both')
        
        self.input_field = ttk.Entry(self.chat_frame)
        self.input_field.pack(fill='x', pady=5)
        
        ttk.Button(self.chat_frame, text="Send", command=self.send_message).pack()

    def create_settings_widgets(self):
        ttk.Label(self.settings_frame, text="Cloud API URL:").pack(pady=5)
        self.api_url_var = tk.StringVar(value=self.cart_manager.cloud_api_url)
        ttk.Entry(self.settings_frame, textvariable=self.api_url_var).pack(pady=5)
        ttk.Button(self.settings_frame, text="Update API URL", command=self.update_api_url).pack(pady=5)

    def add_item(self):
        # Implement add item functionality
        pass

    def view_cart(self):
        cart = self.cart_manager.get_cart()
        messagebox.showinfo("Cart Contents", str(cart))

    def remove_item(self):
        # Implement remove item functionality
        pass

    def mark_received(self):
        # Implement mark as received functionality
        pass

    def manual_sync(self):
        self.cart_manager.manual_update()
        messagebox.showinfo("Sync", "Manual sync completed")

    def send_message(self):
        user_input = self.input_field.get()
        bot_response = get_bot_response(user_input)
        self.chat_log.config(state='normal')
        self.chat_log.insert(tk.END, f"You: {user_input}\n")
        self.chat_log.insert(tk.END, f"AdaptBot: {bot_response}\n")
        self.chat_log.config(state='disabled')
        self.input_field.delete(0, tk.END)

    def update_api_url(self):
        new_url = self.api_url_var.get()
        self.cart_manager.cloud_api_url = new_url
        messagebox.showinfo("Settings", "API URL updated successfully")

root = tk.Tk()
app = AdaptApp(root)
root.mainloop()