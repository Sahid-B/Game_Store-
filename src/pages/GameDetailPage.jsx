// src/pages/GameDetailPage.jsx
import { useParams } from 'react-router-dom';
import { games } from '../data/mock';
import { Button } from '../components/Button';
import { StarRating } from '../components/StarRating';
import { useCart } from '../contexts/CartContext';
import { useWishlist } from '../contexts/WishlistContext';

export const GameDetailPage = () => {
  const { id } = useParams();
  const game = games.find(g => g.id === parseInt(id));
  const { addToCart } = useCart();
  const { addToWishlist } = useWishlist();

  if (!game) {
    return <div>Game not found</div>;
  }

  return (
    <div className="space-y-12">
      <section className="relative h-[400px] rounded-lg overflow-hidden">
        <img src={game.screenshots[0]} alt={game.title} className="w-full h-full object-cover" />
        <div className="absolute inset-0 bg-gradient-to-t from-navy-900 via-transparent to-transparent" />
        <div className="absolute bottom-0 left-0 p-8">
          <h1 className="text-4xl font-bold text-white">{game.title}</h1>
          <StarRating rating={game.rating} className="mt-2" />
        </div>
      </section>

      <section className="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div className="md:col-span-2">
          <h2 className="text-2xl font-bold mb-4">About the Game</h2>
          <p>{game.description}</p>
        </div>
        <div className="space-y-4">
          <Button size="lg" className="w-full" onClick={() => addToCart(game)}>Add to Cart - ${game.price}</Button>
          <Button size="lg" variant="secondary" className="w-full" onClick={() => addToWishlist(game)}>Add to Wishlist</Button>
        </div>
      </section>

      <section>
        <h2 className="text-2xl font-bold mb-4">Screenshots</h2>
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
          {game.screenshots.map((ss, index) => (
            <img key={index} src={ss} alt={`Screenshot ${index + 1}`} className="rounded-lg" />
          ))}
        </div>
      </section>

      <section>
        <h2 className="text-2xl font-bold mb-4">User Reviews</h2>
        <div className="space-y-6">
          {game.reviews.map((review, index) => (
            <div key={index} className="bg-navy-800 p-4 rounded-lg">
              <div className="flex items-center mb-2">
                <p className="font-bold">{review.user}</p>
                <StarRating rating={review.rating} className="ml-4" />
              </div>
              <p>{review.comment}</p>
            </div>
          ))}
        </div>
      </section>
    </div>
  );
};
