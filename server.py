from flask import Flask, request, jsonify
from src.database import add_brand, add_franchise, add_ad
from src.deal_fetcher import fetch_deals_by_category, get_hot_deals, get_trending_deals
from src.pricing import calculate_ad_price

app = Flask(__name__)

@app.route('/add_brand', methods=['POST'])
def api_add_brand():
    data = request.json
    brand_id = add_brand(data['brand_name'], data['head_quarters'], data['tax_id'], 
                         data['address1'], data['address2'], data['state'], data['city'], 
                         data['zip_code'], data['phone'], data['icon'])
    return jsonify({'brand_id': brand_id}), 200

@app.route('/add_franchise', methods=['POST'])
def api_add_franchise():
    data = request.json
    store_id = add_franchise(data['brand_id'], data['store_no'], data['owner_id'], 
                             data['manager'], data['addr_str'], data['city'], 
                             data['state'], data['phone'], data['email'])
    return jsonify({'store_id': store_id}), 200

@app.route('/add_ad', methods=['POST'])
def api_add_ad():
    data = request.json
    ad_id = add_ad(data['store_id'], data['slogan'], data['description'], 
                   data['img'], data['total_paid'], data['start'], 
                   data['end'], data['url'], data['zip_code'])
    return jsonify({'ad_id': ad_id}), 200

@app.route('/fetch_deals', methods=['GET'])
def api_fetch_deals():
    category_id = request.args.get('category_id', type=int)
    lat = request.args.get('lat', type=float)
    lon = request.args.get('lon', type=float)
    deals = fetch_deals_by_category(category_id, (lat, lon))
    return jsonify({'deals': deals}), 200

@app.route('/get_hot_deals', methods=['GET'])
def api_get_hot_deals():
    user_id = request.args.get('user_id', type=int)
    lat = request.args.get('lat', type=float)
    lon = request.args.get('lon', type=float)
    hot_deals = get_hot_deals(user_id, (lat, lon))
    return jsonify({'hot_deals': hot_deals}), 200

@app.route('/get_trending_deals', methods=['GET'])
def api_get_trending_deals():
    lat = request.args.get('lat', type=float)
    lon = request.args.get('lon', type=float)
    trending_deals = get_trending_deals((lat, lon))
    return jsonify({'trending_deals': trending_deals}), 200

@app.route('/calculate_price', methods=['GET'])
def api_calculate_price():
    num_zip_codes = request.args.get('num_zip_codes', type=int)
    num_ads = request.args.get('num_ads', type=int)
    price = calculate_ad_price(num_zip_codes, num_ads)
    return jsonify({'price': price}), 200

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=4322)