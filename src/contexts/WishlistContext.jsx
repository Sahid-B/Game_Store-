// src/contexts/WishlistContext.jsx
import { createContext, useState, useContext } from 'react';

const WishlistContext = createContext();

export const useWishlist = () => useContext(WishlistContext);

export const WishlistProvider = ({ children }) => {
  const [wishlistItems, setWishlistItems] = useState([]);

  const addToWishlist = (game) => {
    setWishlistItems(prevItems => [...prevItems, game]);
  };

  const removeFromWishlist = (gameId) => {
    setWishlistItems(prevItems => prevItems.filter(item => item.id !== gameId));
  };

  const value = {
    wishlistItems,
    addToWishlist,
    removeFromWishlist,
  };

  return <WishlistContext.Provider value={value}>{children}</WishlistContext.Provider>;
};
