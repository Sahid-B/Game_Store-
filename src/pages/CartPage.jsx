// src/pages/CartPage.jsx
import { useCart } from '../contexts/CartContext';
import { Button } from '../components/Button';
import { Link } from 'react-router-dom';
import { X } from 'lucide-react';

export const CartPage = () => {
  const { cartItems, removeFromCart } = useCart();
  const subtotal = cartItems.reduce((acc, item) => acc + item.price * item.quantity, 0);

  return (
    <div>
      <h1 className="text-3xl font-bold mb-8">Your Cart</h1>
      {cartItems.length === 0 ? (
        <div className="text-center bg-navy-800 p-8 rounded-lg">
          <h2 className="text-2xl font-bold mb-4">Your cart is empty.</h2>
          <Link to="/catalog">
            <Button>Browse Games</Button>
          </Link>
        </div>
      ) : (
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div className="md:col-span-2 space-y-4">
            {cartItems.map(item => (
              <div key={item.id} className="flex items-center bg-navy-800 p-4 rounded-lg">
                <img src={item.image} alt={item.title} className="w-24 h-24 object-cover rounded-md" />
                <div className="ml-4 flex-grow">
                  <h3 className="font-bold">{item.title}</h3>
                  <p>Quantity: {item.quantity}</p>
                </div>
                <p className="font-bold text-neon-pink">${(item.price * item.quantity).toFixed(2)}</p>
                <button onClick={() => removeFromCart(item.id)} className="ml-4">
                  <X className="h-6 w-6 text-light-slate hover:text-neon-pink" />
                </button>
              </div>
            ))}
          </div>
          <div className="bg-navy-800 p-6 rounded-lg">
            <h2 className="text-xl font-bold mb-4">Order Summary</h2>
            <div className="flex justify-between mb-2">
              <span>Subtotal</span>
              <span>${subtotal.toFixed(2)}</span>
            </div>
            <div className="flex justify-between mb-4">
              <span>Taxes</span>
              <span>Calculated at checkout</span>
            </div>
            <hr className="border-navy-900 my-4" />
            <div className="flex justify-between font-bold text-lg">
              <span>Total</span>
              <span>${subtotal.toFixed(2)}</span>
            </div>
            <Link to="/checkout" className="mt-6 block">
              <Button size="lg" className="w-full">Proceed to Checkout</Button>
            </Link>
          </div>
        </div>
      )}
    </div>
  );
};
