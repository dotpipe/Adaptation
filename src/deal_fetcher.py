import pymysql
from datetime import datetime

# Assume these are imported from a config file
DB_HOST = 'remote_host'
DB_USER = 'username'
DB_PASSWORD = 'password'
DB_NAME = 'ADAPT'

def get_db_connection():
    return pymysql.connect(host=DB_HOST,
                           user=DB_USER,
                           password=DB_PASSWORD,
                           db=DB_NAME,
                           cursorclass=pymysql.cursors.DictCursor)

def fetch_hourly_deals():
    deals = {}
    try:
        with get_db_connection() as connection:
            with connection.cursor() as cursor:
                # Fetch active ads from the ADVS table
                cursor.execute("""
                    SELECT STORE_NAME, SLOGAN, DESCRIPTION, IMG, URL, ZIP 
                    FROM ADVS 
                    WHERE START <= NOW() AND END >= NOW()
                """)
                ads = cursor.fetchall()

                for ad in ads:
                    store_name = ad['STORE_NAME']
                    if store_name not in deals:
                        deals[store_name] = []
                    deals[store_name].append({
                        'slogan': ad['SLOGAN'],
                        'description': ad['DESCRIPTION'],
                        'image': ad['IMG'],
                        'url': ad['URL'],
                        'zip': ad['ZIP']
                    })

    except Exception as e:
        print(f"Error fetching deals: {e}")

    return deals

def update_ad_views(store_name):
    try:
        with get_db_connection() as connection:
            with connection.cursor() as cursor:
                cursor.execute("""
                    UPDATE ADVS 
                    SET SEEN = SEEN + 1 
                    WHERE STORE_NAME = %s AND START <= NOW() AND END >= NOW()
                """, (store_name,))
                connection.commit()
    except Exception as e:
        print(f"Error updating ad views: {e}")

# You can add more functions here to interact with other tables as needed