import React, { createContext, useState, useEffect } from 'react';
import { CartManager } from './CartManager';

export const CartContext = createContext();

export const CartProvider = ({ children }) => {
  const [cart, setCart] = useState([]);
  const cartManager = new CartManager('adapt.db', 'https://api.adapt.com/cart');

  useEffect(() => {
    // Initialize cart from local database
    setCart(cartManager.get_cart());

    // Set up periodic sync
    const syncInterval = setInterval(() => {
      cartManager.sync_with_cloud();
    }, 3 * 60 * 60 * 1000); // 3 hours

    return () => clearInterval(syncInterval);
  }, []);

  const addToCart = (item) => {
    cartManager.add_to_cart(item);
    setCart(cartManager.get_cart());
  };

  const removeFromCart = (itemId) => {
    cartManager.remove_from_cart(itemId);
    setCart(cartManager.get_cart());
  };

  const manualUpdate = () => {
    cartManager.manual_update();
    setCart(cartManager.get_cart());
  };

  return (
    <CartContext.Provider value={{ cart, addToCart, removeFromCart, manualUpdate }}>
      {children}
    </CartContext.Provider>
  );
};