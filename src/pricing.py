def calculate_ad_price(num_zip_codes, num_ads):
    zip_price = 1 if num_zip_codes == 1 else 2 if num_zip_codes == 2 else 5
    ad_price = 1 if num_ads == 1 else 2 if num_ads == 2 else 5
    return zip_price * ad_price