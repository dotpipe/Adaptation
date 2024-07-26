from geopy.distance import distance
import requests
from statistics import mean
from geopy.geocoders import Nominatim

def calculate_central_point(zip_codes):
    geolocator = Nominatim(user_agent="adapt_app")
    coordinates = []
    for zip_code in zip_codes:
        location = geolocator.geocode(f"{zip_code}, USA")
        if location:
            coordinates.append((location.latitude, location.longitude))
    
    central_lat = mean(coord[0] for coord in coordinates)
    central_lon = mean(coord[1] for coord in coordinates)
    return central_lat, central_lon

def is_in_distribution_circle(user_coords, store_coords, radius):
    return distance(user_coords, store_coords).miles <= radius

def get_nearby_deals(user_coords, watched_zip_codes):
    api_url = "https://api.adapt.com/stores"
    params = {"zip_codes": ",".join(watched_zip_codes)}
    response = requests.get(api_url, params=params)
    stores = response.json()

    nearby_deals = []
    for store in stores:
        if is_in_distribution_circle(user_coords, (store['latitude'], store['longitude']), store['radius']):
            deals = fetch_deals_by_store(store['STORE_NO'])
            nearby_deals.extend(deals)
    return nearby_deals