// src/components/GameCard.jsx
import { Link } from 'react-router-dom';
import { Button } from './Button';
import { Star } from 'lucide-react';
import { useCart } from '../contexts/CartContext';
import { useWishlist } from '../contexts/WishlistContext';

export const GameCard = ({ game }) => {
  const { addToCart } = useCart();
  const { addToWishlist } = useWishlist();

  return (
    <div className="group relative overflow-hidden rounded-lg shadow-lg transition-transform duration-300 ease-in-out hover:-translate-y-2">
      <Link to={`/game/${game.id}`}>
        <img src={game.image} alt={game.title} className="w-full h-auto object-cover" />
        <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent" />
        <div className="absolute bottom-0 left-0 p-4">
          <h3 className="text-lg font-bold text-white">{game.title}</h3>
          <div className="flex items-center">
            {[...Array(5)].map((_, i) => (
              <Star key={i} className={`h-4 w-4 ${i < game.rating ? 'text-yellow-400 fill-current' : 'text-gray-600'}`} />
            ))}
          </div>
        </div>
      </Link>
      <div className="absolute top-2 right-2 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
        <Button size="sm" onClick={() => addToCart(game)}>Add to Cart</Button>
        <Button size="sm" variant="secondary" onClick={() => addToWishlist(game)}>Wishlist</Button>
      </div>
      <div className="absolute bottom-4 right-4 text-lg font-bold text-neon-pink">${game.price}</div>
    </div>
  );
};
