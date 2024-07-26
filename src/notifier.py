from win10toast import ToastNotifier
import tkinter as tk
from tkinter import ttk
import json

class DealNotifier:
    def __init__(self, master):
        self.master = master
        self.master.title("Adapt Deal Notifier")
        self.toaster = ToastNotifier()
        self.current_deals = {}
        self.load_cached_deals()
        self.create_widgets()

    def create_widgets(self):
        self.notebook = ttk.Notebook(self.master)
        self.notebook.pack(expand=True, fill='both')

        self.deals_frame = ttk.Frame(self.notebook)
        self.settings_frame = ttk.Frame(self.notebook)

        self.notebook.add(self.deals_frame, text='Deals')
        self.notebook.add(self.settings_frame, text='Settings')

        self.create_deals_widgets()
        self.create_settings_widgets()

    def create_deals_widgets(self):
        self.deals_tree = ttk.Treeview(self.deals_frame, columns=('Store', 'Title', 'Description'))
        self.deals_tree.heading('Store', text='Store')
        self.deals_tree.heading('Title', text='Title')
        self.deals_tree.heading('Description', text='Description')
        self.deals_tree.pack(expand=True, fill='both')

        self.deals_tree.bind('<Double-1>', self.on_deal_select)

        self.update_deals_view()

    def create_settings_widgets(self):
        self.theme_var = tk.StringVar(value='light')
        self.view_var = tk.StringVar(value='category')

        ttk.Radiobutton(self.settings_frame, text='Light Mode', variable=self.theme_var, value='light', command=self.update_theme).pack()
        ttk.Radiobutton(self.settings_frame, text='Dark Mode', variable=self.theme_var, value='dark', command=self.update_theme).pack()

        ttk.Radiobutton(self.settings_frame, text='View by Category', variable=self.view_var, value='category', command=self.update_deals_view).pack()
        ttk.Radiobutton(self.settings_frame, text='View by Store', variable=self.view_var, value='store', command=self.update_deals_view).pack()

    def load_cached_deals(self):
        try:
            with open('cached_deals.json', 'r') as f:
                self.current_deals = json.load(f)
        except FileNotFoundError:
            self.current_deals = {}

    def save_cached_deals(self):
        with open('cached_deals.json', 'w') as f:
            json.dump(self.current_deals, f)

    def show_notifications(self):
        for store, deals in self.current_deals.items():
            for deal in deals:
                self.toaster.show_toast(
                    f"New Deal from {store}",
                    deal['title'],
                    duration=10,
                    callback_on_click=lambda s=store, d=deal: self.open_deal_window(s, d)
                )

    def open_deal_window(self, store, deal):
        deal_window = tk.Toplevel(self.master)
        deal_window.title(f"Deal from {store}")
        ttk.Label(deal_window, text=deal['title']).pack()
        ttk.Label(deal_window, text=deal['description']).pack()
        ttk.Button(deal_window, text="Close", command=deal_window.destroy).pack()

    def update_theme(self):
        # Implement theme switching logic here
        pass

    def update_deals_view(self):
        self.deals_tree.delete(*self.deals_tree.get_children())
        view_type = self.view_var.get()
        
        if view_type == 'category':
            # Implement category view logic
            pass
        else:  # store view
            for store, deals in self.current_deals.items():
                for deal in deals:
                    self.deals_tree.insert('', 'end', values=(store, deal['title'], deal['description']))

    def on_deal_select(self, event):
        item = self.deals_tree.selection()[0]
        store, title, description = self.deals_tree.item(item, 'values')
        deal = {'title': title, 'description': description}
        self.open_deal_window(store, deal)

if __name__ == "__main__":
    root = tk.Tk()
    app = DealNotifier(root)
    root.mainloop()