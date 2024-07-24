from win10toast import ToastNotifier
from gui import open_deal_window

def show_notifications(deals):
    toaster = ToastNotifier()
    for store, deal in deals.items():
        toaster.show_toast(
            f"New Deal from {store}",
            deal['title'],
            duration=10,
            callback_on_click=lambda s=store: open_deal_window(s)
        )