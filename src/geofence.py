import geopy.distance

def is_in_distribution_circle(user_coords, store_coords, radius):
    return geopy.distance.distance(user_coords, store_coords).miles <= radius

def get_nearby_deals(user_coords):
    stores = fetch_all_stores()  # New function to fetch all stores
    nearby_deals = []
    for store in stores:
        if is_in_distribution_circle(user_coords, (store['latitude'], store['longitude']), store['radius']):
            deals = fetch_deals_by_store(store['STORE_NO'])
            nearby_deals.extend(deals)
    return nearby_deals