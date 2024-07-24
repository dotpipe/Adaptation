import schedule
import time
from deal_fetcher import fetch_hourly_deals
from notifier import show_notifications

def run_scheduler():
    schedule.every().hour.at(":00").do(fetch_and_notify)
    while True:
        schedule.run_pending()
        time.sleep(1)

def fetch_and_notify():
    deals = fetch_hourly_deals()
    show_notifications(deals)

if __name__ == "__main__":
    print("Starting Adapt...")
    fetch_and_notify()  # Run immediately on start
    run_scheduler()