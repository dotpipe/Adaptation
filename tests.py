import unittest
from database import init_db, add_brand, add_franchise, add_ad, get_db_connection
from deal_fetcher import fetch_deals_by_category, is_in_range
from pricing import calculate_ad_price

class TestAdaptSystem(unittest.TestCase):

    def setUp(self):
        init_db()
        self.conn = get_db_connection()
        self.cursor = self.conn.cursor()

    def tearDown(self):
        self.conn.close()

    def test_add_brand(self):
        brand_id = add_brand("Test Brand", "Test HQ", "123456789", "123 Main St", "", "State", "City", "12345", "1234567890", "icon.png")
        self.assertIsNotNone(brand_id)
        self.cursor.execute("SELECT * FROM BRANDS WHERE brand_id = ?", (brand_id,))
        self.assertIsNotNone(self.cursor.fetchone())

    def test_add_franchise(self):
        brand_id = add_brand("Test Brand", "Test HQ", "123456789", "123 Main St", "", "State", "City", "12345", "1234567890", "icon.png")
        store_id = add_franchise(brand_id, 1, 1, "John Doe", "456 Oak St", "City", "State", 9876543210, "john@example.com")
        self.assertIsNotNone(store_id)
        self.cursor.execute("SELECT * FROM FRANCHISE WHERE store_id = ?", (store_id,))
        self.assertIsNotNone(self.cursor.fetchone())

    def test_add_ad(self):
        brand_id = add_brand("Test Brand", "Test HQ", "123456789", "123 Main St", "", "State", "City", "12345", "1234567890", "icon.png")
        store_id = add_franchise(brand_id, 1, 1, "John Doe", "456 Oak St", "City", "State", 9876543210, "john@example.com")
        ad_id = add_ad(store_id, "Test Slogan", "Test Description", "ad.jpg", 100.0, "2023-01-01", "2023-12-31", "http://example.com", 12345)
        self.assertIsNotNone(ad_id)
        self.cursor.execute("SELECT * FROM ADVS WHERE id = ?", (ad_id,))
        self.assertIsNotNone(self.cursor.fetchone())

    def test_fetch_deals_by_category(self):
        # Add test data
        brand_id = add_brand("Test Brand", "Test HQ", "123456789", "123 Main St", "", "State", "City", "12345", "1234567890", "icon.png")
        store_id = add_franchise(brand_id, 1, 1, "John Doe", "456 Oak St", "City", "State", 9876543210, "john@example.com")
        add_ad(store_id, "Test Slogan", "Test Description", "ad.jpg", 100.0, "2023-01-01", "2023-12-31", "http://example.com", 12345)
        
        # Test fetching deals
        deals = fetch_deals_by_category(1, (0, 0))  # Assuming category_id 1 and user location (0, 0)
        self.assertIsNotNone(deals)
        self.assertGreater(len(deals), 0)

    def test_is_in_range(self):
        self.assertTrue(is_in_range((0, 0), (0.01, 0.01), 2))  # Should be in range
        self.assertFalse(is_in_range((0, 0), (1, 1), 2))  # Should be out of range

    def test_calculate_ad_price(self):
        self.assertEqual(calculate_ad_price(1, 1), 1)  # 1 zip code, 1 ad
        self.assertEqual(calculate_ad_price(2, 2), 4)  # 2 zip codes, 2 ads
        self.assertEqual(calculate_ad_price(3, 3), 25)  # 3+ zip codes, 3+ ads

if __name__ == '__main__':
    unittest.main()