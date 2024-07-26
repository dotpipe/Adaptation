import sqlite3

DB_NAME = 'adapt_server.db'

def get_db_connection():
    return sqlite3.connect(DB_NAME)

def init_server_db():
    conn = get_db_connection()
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

    # Create FRANCHISE table
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

    # Create ADVS table
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

    conn.commit()
    conn.close()

# Additional server-side functions (e.g., add_brand, add_franchise, add_ad) remain the same as in the original database.py
def add_franchise(brand_id, store_no, owner_id, manager, addr_str, city, state, phone, email, zip_codes):
    conn = get_db_connection()
    c = conn.cursor()
    central_lat, central_lon = calculate_central_point(zip_codes)
    c.execute('''INSERT INTO FRANCHISE (brand_id, store_no, owner_id, manager, addr_str, city, state, phone, email, central_latitude, central_longitude)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)''',
              (brand_id, store_no, owner_id, manager, addr_str, city, state, phone, email, central_lat, central_lon))
    store_id = c.lastrowid
    conn.commit()
    conn.close()
    return store_id

init_server_db()