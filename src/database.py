import sqlite3
from datetime import datetime, timedelta

import smtplib
from email.mime.text import MIMEText

DB_NAME = 'adapt.db'

def get_db_connection():
    return sqlite3.connect(DB_NAME)

def init_db():
    conn = sqlite3.connect(DB_NAME)
    c = conn.cursor()
    
    # Create CATEGORIES table
    c.execute('''CREATE TABLE IF NOT EXISTS CATEGORIES
                 (category_id INTEGER PRIMARY KEY AUTOINCREMENT,
                 category_name TEXT NOT NULL,
                 icon TEXT)''')
    # Create BRANDS table
    c.execute('''CREATE TABLE IF NOT EXISTS BRANDS
                    (brand_id INTEGER PRIMARY KEY AUTOINCREMENT,
                    brand_name TEXT NOT NULL,
                    head_quarters TEXT,
                    tax_id TEXT,
                    address1 TEXT,
                    address2 TEXT,
                    state TEXT,
                    city TEXT,
                    zip_code TEXT,
                    phone TEXT,
                    icon TEXT)''')
    
    # Modify FRANCHISE table
    c.execute('''CREATE TABLE IF NOT EXISTS FRANCHISE
                    (store_id INTEGER PRIMARY KEY AUTOINCREMENT,
                    brand_id INTEGER,
                    store_no INTEGER,
                    owner_id INTEGER,
                    manager TEXT,
                    addr_str TEXT,
                    city TEXT,
                    state TEXT,
                    phone INTEGER,
                    email TEXT,
                    avg_ads_hr REAL,
                    views INTEGER,
                    avg_views_day INTEGER,
                    reviews INTEGER,
                    avg_reviews REAL,
                    category_id INTEGER,
                    latitude REAL,
                    longitude REAL,
                    distribution_radius REAL,
                    FOREIGN KEY (brand_id) REFERENCES BRANDS(brand_id),
                    FOREIGN KEY (category_id) REFERENCES CATEGORIES(category_id))''')
    
    # Modify ADVS table
    c.execute('''CREATE TABLE IF NOT EXISTS ADVS
                    (id INTEGER PRIMARY KEY AUTOINCREMENT,
                    store_id INTEGER,
                    slogan TEXT,
                    description TEXT,
                    img TEXT,
                    total_paid REAL,
                    last_paid_on TIMESTAMP,
                    flagged INTEGER,
                    start TIMESTAMP,
                    end TIMESTAMP,
                    url TEXT,
                    seen INTEGER,
                    zip INTEGER,
                    nums INTEGER,
                    price_tier INTEGER,
                    zip_codes TEXT,
                    FOREIGN KEY (store_id) REFERENCES FRANCHISE(store_id))''')
    
    # Create RESERVATIONS table
    c.execute('''CREATE TABLE IF NOT EXISTS RESERVATIONS
                 (id INTEGER PRIMARY KEY AUTOINCREMENT,
                 customer TEXT,
                 store_name TEXT,
                 product TEXT,
                 quantity INTEGER,
                 reservation_time DATETIME,
                 status TEXT)''')
    
    # Create ORDERS table
    c.execute('''CREATE TABLE IF NOT EXISTS ORDERS
                 (id INTEGER PRIMARY KEY AUTOINCREMENT,
                 customer TEXT,
                 store_name TEXT,
                 order_date DATETIME,
                 status TEXT)''')

    # Create HOLDS table
    c.execute('''CREATE TABLE IF NOT EXISTS HOLDS
                 (id INTEGER PRIMARY KEY AUTOINCREMENT,
                 customer TEXT,
                 product TEXT,
                 quantity INTEGER,
                 hold_date DATETIME DEFAULT CURRENT_TIMESTAMP,
                 expiry_date DATETIME)''')

    # Create ORDER_ITEMS table
    c.execute('''CREATE TABLE IF NOT EXISTS ORDER_ITEMS
                 (id INTEGER PRIMARY KEY AUTOINCREMENT,
                 order_id INTEGER,
                 product TEXT,
                 quantity INTEGER,
                 price REAL,
                 FOREIGN KEY (order_id) REFERENCES ORDERS(id))''')

    c.execute('''CREATE TABLE IF NOT EXISTS HOTLISTS
                 (id INTEGER PRIMARY KEY AUTOINCREMENT,
                 user_id INTEGER,
                 item TEXT,
                 FOREIGN KEY (user_id) REFERENCES USER(user_id))''')
    
    conn.commit()
    conn.close()
def share_ad(ad_id, user_id, platform):
    conn = get_db_connection()
    c = conn.cursor()
    
    # Increment share count
    c.execute('UPDATE ADVS SET shares = shares + 1 WHERE SERIAL = ?', (ad_id,))
    
    # Log the share action
    c.execute('INSERT INTO AD_SHARES (ad_id, user_id, platform, share_time) VALUES (?, ?, ?, CURRENT_TIMESTAMP)', 
              (ad_id, user_id, platform))
    
    conn.commit()
    conn.close()
def place_bid(station_id, bid_amount, duration):
    with get_db_connection() as conn:
        cursor = conn.cursor()
        cursor.execute("""
            INSERT INTO station_bids (station_id, bid_amount, start_time, end_time)
            VALUES (?, ?, CURRENT_TIMESTAMP, DATETIME(CURRENT_TIMESTAMP, '+' || ? || ' hours'))
        """, (station_id, bid_amount, duration))
        conn.commit()
def add_brand(brand_name, head_quarters, tax_id, address1, address2, state, city, zip_code, phone, icon):
    conn = get_db_connection()
    c = conn.cursor()
    c.execute('''INSERT INTO BRANDS (brand_name, head_quarters, tax_id, address1, address2, state, city, zip_code, phone, icon)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)''',
              (brand_name, head_quarters, tax_id, address1, address2, state, city, zip_code, phone, icon))
    brand_id = c.lastrowid
    conn.commit()
    conn.close()
    return brand_id

def add_franchise(brand_id, store_no, owner_id, manager, addr_str, city, state, phone, email):
    conn = get_db_connection()
    c = conn.cursor()
    c.execute('''INSERT INTO FRANCHISE (brand_id, store_no, owner_id, manager, addr_str, city, state, phone, email)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)''',
              (brand_id, store_no, owner_id, manager, addr_str, city, state, phone, email))
    store_id = c.lastrowid
    conn.commit()
    conn.close()
    return store_id

def add_ad(store_id, slogan, description, img, total_paid, start, end, url, zip_code):
    conn = get_db_connection()
    c = conn.cursor()
    c.execute('''INSERT INTO ADVS (store_id, slogan, description, img, total_paid, start, end, url, zip)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)''',
              (store_id, slogan, description, img, total_paid, start, end, url, zip_code))
    ad_id = c.lastrowid
    conn.commit()
    conn.close()
    return ad_id

def get_active_bids():
    with get_db_connection() as conn:
        cursor = conn.cursor()
        cursor.execute("""
            SELECT * FROM station_bids
            WHERE end_time > CURRENT_TIMESTAMP
            ORDER BY bid_amount DESC
        """)
        return cursor.fetchall()
def check_hotlist_deals():
    conn = get_db_connection()
    c = conn.cursor()
    c.execute('''SELECT h.user_id, h.item, a.STORE_NAME, a.DESCRIPTION, a.URL
                 FROM HOTLISTS h
                 JOIN ADVS a ON h.item LIKE '%' || a.DESCRIPTION || '%'
                 WHERE a.START <= CURRENT_TIMESTAMP AND a.END >= CURRENT_TIMESTAMP''')
    matches = c.fetchall()
    conn.close()

    for match in matches:
        send_hotlist_email(match[0], match[1], match[2], match[3], match[4])

def send_hotlist_email(user_id, item, store, description, url):
    user_email = get_user_email(user_id)  # Implement this function to fetch user's email
    subject = f"Deal Alert: {item} at {store}"
    body = f"We found a deal for your hotlist item '{item}'!\n\n{description}\n\nCheck it out here: {url}"

    msg = MIMEText(body)
    msg['Subject'] = subject
    msg['From'] = "deals@adapt.com"
    msg['To'] = user_email

    s = smtplib.SMTP('localhost')
    s.send_message(msg)
    s.quit()

def store_deals(deals):
    conn = get_db_connection()
    c = conn.cursor()
    for store, deal in deals.items():
        c.execute("""INSERT INTO ADVS (STORE_NAME, SLOGAN, DESCRIPTION, IMG, TOTAL_PAID, START, END, URL, ZIP, price_tier, zip_codes) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)""",
                  (store, deal['slogan'], deal['description'], deal['img'], deal['total_paid'],
                   deal['start'], deal['end'], deal['url'], deal['zip'], deal['price_tier'], deal['zip_codes']))
    conn.commit()
    conn.close()

def get_store_deals(store, hours=24):
    conn = get_db_connection()
    c = conn.cursor()
    time_threshold = datetime.now() - timedelta(hours=hours)
    c.execute("""SELECT SLOGAN, DESCRIPTION, IMG, URL, ZIP, price_tier, zip_codes 
                 FROM ADVS WHERE STORE_NAME = ? AND START > ? ORDER BY START DESC""",
              (store, time_threshold))
    deals = [dict(zip(['slogan', 'description', 'img', 'url', 'zip', 'price_tier', 'zip_codes'], row)) for row in c.fetchall()]
    conn.close()
    return deals

def get_deals_by_category(category_id):
    conn = get_db_connection()
    c = conn.cursor()
    c.execute("""SELECT a.SLOGAN, a.DESCRIPTION, a.IMG, a.URL, a.ZIP, a.price_tier, a.zip_codes, f.STORE_NAME
                 FROM ADVS a
                 JOIN FRANCHISE f ON a.STORE_NAME = f.STORE_NAME
                 WHERE f.category_id = ? AND a.START <= datetime('now') AND a.END >= datetime('now')""",
              (category_id,))
    deals = [dict(zip(['slogan', 'description', 'img', 'url', 'zip', 'price_tier', 'zip_codes', 'store_name'], row)) for row in c.fetchall()]
    conn.close()
    return deals

def update_ad_views(ad_id):
    conn = get_db_connection()
    c = conn.cursor()
    c.execute("UPDATE ADVS SET SEEN = SEEN + 1 WHERE ID = ?", (ad_id,))
    conn.commit()
    conn.close()
def compare_gas_prices(user_location):
    nearby_stations = get_nearby_stations(user_location)
    sorted_stations = sorted(nearby_stations, key=lambda x: x['price'])
    return sorted_stations[:3]  # Return top 3 cheapest stations
def create_preorder(customer, store_name, product, quantity, needed_by):
    with get_db_connection() as conn:
        cursor = conn.cursor()
        cursor.execute("""
            INSERT INTO PREORDERS (CUSTOMER, STORE_NAME, PRODUCT, QUANTITY, NEEDED_BY, DELIVERED, ACTION)
            VALUES (?, ?, ?, ?, ?, 0, 0)
        """, (customer, store_name, product, quantity, needed_by))
        conn.commit()
        return cursor.lastrowid
def create_reservation(customer, store_name, product, quantity, reservation_time):
    with get_db_connection() as conn:
        cursor = conn.cursor()
        cursor.execute("""
            INSERT INTO RESERVATIONS (CUSTOMER, STORE_NAME, PRODUCT, QUANTITY, RESERVATION_TIME, STATUS)
            VALUES (?, ?, ?, ?, ?, 'PENDING')
        """, (customer, store_name, product, quantity, reservation_time))
        conn.commit()
        return cursor.lastrowid
def place_order(customer, store_name, items):
    with get_db_connection() as conn:
        cursor = conn.cursor()
        order_id = cursor.execute("INSERT INTO ORDERS (CUSTOMER, STORE_NAME, ORDER_DATE) VALUES (?, ?, CURRENT_TIMESTAMP)", (customer, store_name)).lastrowid
        for item in items:
            cursor.execute("""
                INSERT INTO ORDER_ITEMS (ORDER_ID, PRODUCT, QUANTITY, PRICE)
                VALUES (?, ?, ?, ?)
            """, (order_id, item['product'], item['quantity'], item['price']))
        conn.commit()
        return order_id
def check_order_status(order_id):
    with get_db_connection() as conn:
        cursor = conn.cursor()
        cursor.execute("SELECT STATUS FROM ORDERS WHERE ID = ?", (order_id,))
        return cursor.fetchone()[0]

def display_price_comparison(user_id):
    user_location = get_user_location(user_id)
    cheapest_stations = compare_gas_prices(user_location)
    message = "Cheapest gas stations nearby:\n"
    for station in cheapest_stations:
        message += f"{station['name']}: ${station['price']}\n"
    send_notification(user_id, message)
from geopy.distance import distance

def check_geofence(user_location, station_location, radius):
    return distance(user_location, station_location).miles <= radius

def monitor_user_location(user_id):
    while True:
        user_location = get_user_location(user_id)
        nearby_stations = get_nearby_stations(user_location)
        for station in nearby_stations:
            if check_geofence(user_location, station['location'], station['radius']):
                send_notification(user_id, f"You're near {station['name']}! Current gas price: ${station['price']}")
        time.sleep(60)  # Check every minute

init_db()  # Initialize the database when this module is imported