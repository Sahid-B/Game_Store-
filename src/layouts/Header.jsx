// src/layouts/Header.jsx
import { Link } from 'react-router-dom';
import { ShoppingCart, Heart, User } from 'lucide-react';
import { useCart } from '../contexts/CartContext';
import { useAuth } from '../contexts/AuthContext';
import { Button } from '../components/Button';

export const Header = () => {
  const { cartItems } = useCart();
  const { currentUser, logout } = useAuth();
  const cartItemCount = cartItems.reduce((acc, item) => acc + item.quantity, 0);

  return (
    <header className="fixed top-0 left-0 right-0 z-50 bg-navy-900/80 backdrop-blur-sm shadow-md">
      <div className="container mx-auto px-4">
        <div className="flex items-center justify-between h-20">
          <Link to="/" className="text-2xl font-bold text-white">GameStore+</Link>
          <nav className="hidden md:flex items-center gap-6">
            <Link to="/catalog" className="text-light-slate hover:text-neon-pink transition-colors">Catalog</Link>
            {currentUser && currentUser.role === 'admin' && (
              <Link to="/admin" className="text-light-slate hover:text-neon-pink transition-colors">Admin</Link>
            )}
          </nav>
          <div className="flex items-center gap-4">
            <Link to="/wishlist" className="relative">
              <Heart className="h-6 w-6 text-light-slate hover:text-neon-pink transition-colors" />
            </Link>
            <Link to="/cart" className="relative">
              <ShoppingCart className="h-6 w-6 text-light-slate hover:text-neon-pink transition-colors" />
              {cartItemCount > 0 && (
                <span className="absolute -top-2 -right-2 flex h-5 w-5 items-center justify-center rounded-full bg-neon-pink text-xs text-white">
                  {cartItemCount}
                </span>
              )}
            </Link>
            {currentUser ? (
              <>
                <Link to="/profile">
                  <User className="h-6 w-6 text-light-slate hover:text-neon-pink transition-colors" />
                </Link>
                <Button size="sm" variant="outline" onClick={logout}>Logout</Button>
              </>
            ) : (
              <Link to="/login">
                <Button size="sm">Login</Button>
              </Link>
            )}
          </div>
        </div>
      </div>
    </header>
  );
};
