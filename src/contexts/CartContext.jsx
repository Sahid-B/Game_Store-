// src/contexts/CartContext.jsx
import { createContext, useState, useContext } from 'react';
import { useToast } from './ToastContext';

const CartContext = createContext();

export const useCart = () => useContext(CartContext);

export const CartProvider = ({ children }) => {
  const [cartItems, setCartItems] = useState([]);
  const { addToast } = useToast();

  const addToCart = (game) => {
    setCartItems(prevItems => {
      const itemExists = prevItems.find(item => item.id === game.id);
      if (itemExists) {
        return prevItems.map(item =>
          item.id === game.id ? { ...item, quantity: item.quantity + 1 } : item
        );
      }
      return [...prevItems, { ...game, quantity: 1 }];
    });
    addToast(`${game.title} added to cart!`);
  };

  const removeFromCart = (gameId) => {
    setCartItems(prevItems => prevItems.filter(item => item.id !== gameId));
    addToast('Item removed from cart', 'error');
  };

  const value = {
    cartItems,
    addToCart,
    removeFromCart,
  };

  return <CartContext.Provider value={value}>{children}</CartContext.Provider>;
};
