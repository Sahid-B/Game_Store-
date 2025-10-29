// src/pages/WishlistPage.jsx
import { useWishlist } from '../contexts/WishlistContext';
import { GameCard } from '../components/GameCard';
import { Button } from '../components/Button';
import { Link } from 'react-router-dom';

export const WishlistPage = () => {
  const { wishlistItems, removeFromWishlist } = useWishlist();

  return (
    <div>
      <h1 className="text-3xl font-bold mb-8">Your Wishlist</h1>
      {wishlistItems.length === 0 ? (
        <div className="text-center bg-navy-800 p-8 rounded-lg">
          <h2 className="text-2xl font-bold mb-4">Your wishlist is empty.</h2>
          <Link to="/catalog">
            <Button>Browse Games</Button>
          </Link>
        </div>
      ) : (
        <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
          {wishlistItems.map(game => (
            <div key={game.id} className="relative">
              <GameCard game={game} />
              <Button
                variant="secondary"
                size="sm"
                className="absolute top-4 right-4"
                onClick={() => removeFromWishlist(game.id)}
              >
                Remove
              </Button>
            </div>
          ))}
        </div>
      )}
    </div>
  );
};
