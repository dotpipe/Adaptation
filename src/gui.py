import tkinter as tk
import webbrowser
from deal_fetcher import fetch_hourly_deals, update_ad_views

def open_deal_window():
    deals = fetch_hourly_deals()
    
    window = tk.Tk()
    window.title("Adapt - Latest Deals")
    window.geometry("600x400")

    main_frame = tk.Frame(window)
    main_frame.pack(fill=tk.BOTH, expand=1)

    canvas = tk.Canvas(main_frame)
    canvas.pack(side=tk.LEFT, fill=tk.BOTH, expand=1)

    scrollbar = tk.Scrollbar(main_frame, orient=tk.VERTICAL, command=canvas.yview)
    scrollbar.pack(side=tk.RIGHT, fill=tk.Y)

    canvas.configure(yscrollcommand=scrollbar.set)
    canvas.bind('<Configure>', lambda e: canvas.configure(scrollregion=canvas.bbox("all")))

    inner_frame = tk.Frame(canvas)
    canvas.create_window((0, 0), window=inner_frame, anchor="nw")

    for store_name, store_deals in deals.items():
        store_frame = tk.LabelFrame(inner_frame, text=store_name, padx=5, pady=5)
        store_frame.pack(fill=tk.X, padx=10, pady=5)

        for deal in store_deals:
            deal_frame = tk.Frame(store_frame)
            deal_frame.pack(fill=tk.X, padx=5, pady=2)

            tk.Label(deal_frame, text=deal['slogan'], wraplength=400, font=("Arial", 12, "bold")).pack(anchor="w")
            tk.Label(deal_frame, text=deal['description'], wraplength=400).pack(anchor="w")
            
            def open_url(url=deal['url']):
                update_ad_views(store_name)
                webbrowser.open(url)

            tk.Button(deal_frame, text="View Deal", command=open_url).pack(anchor="e")

    window.mainloop()
def create_category_dropdown(parent):
    categories = fetch_categories()  # New function to fetch categories from DB
    var = tk.StringVar(parent)
    var.set(categories[0])  # Set default value
    dropdown = tk.OptionMenu(parent, var, *categories)
    dropdown.pack()
    return var

def calculate_ad_price(num_zip_codes, num_ads):
    zip_price = 1 if num_zip_codes == 1 else 2 if num_zip_codes == 2 else 5
    ad_price = 1 if num_ads == 1 else 2 if num_ads == 2 else 5
    return zip_price * ad_price

def on_category_change(*args):
    selected_category = category_var.get()
    update_deals_display(selected_category)

def create_share_button(parent, ad_id, user_id):
    def on_share():
        platform = simpledialog.askstring("Share", "Enter sharing platform:")
        if platform:
            share_ad(ad_id, user_id, platform)
            messagebox.showinfo("Shared", f"Ad shared on {platform}")
    
    return tk.Button(parent, text="Share", command=on_share)

def fetch_deals_by_category(category_id, zip_code):
    with get_db_connection() as connection:
        with connection.cursor() as cursor:
            cursor.execute("""
                SELECT a.*, f.STORE_NAME 
                FROM ADVS a
                JOIN FRANCHISE f ON a.STORE_NO = f.STORE_NO
                WHERE f.category_id = %s AND a.ZIP = %s
                AND a.START <= NOW() AND a.END >= NOW()
            """, (category_id, zip_code))
            return cursor.fetchall()

category_var = create_category_dropdown(window)
category_var.trace('w', on_category_change)

if __name__ == "__main__":
    open_deal_window()