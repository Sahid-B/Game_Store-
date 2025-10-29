// src/pages/HomePage.jsx
import { GameCard } from '../components/GameCard';
import { games } from '../data/mock';

export const HomePage = () => {
  const popularGames = games.filter(g => g.tags.includes('popular')).slice(0, 4);
  const newGames = games.filter(g => g.tags.includes('new')).slice(0, 4);

  return (
    <div className="space-y-16">
      <section className="relative h-[500px] rounded-lg overflow-hidden">
        <img src="/images/hero-bg.jpg" alt="Hero Background" className="w-full h-full object-cover" />
        <div className="absolute inset-0 bg-black/60 flex items-center justify-center">
          <div className="text-center">
            <h1 className="text-4xl md:text-6xl font-bold text-white">Your Next Adventure Awaits</h1>
            <p className="text-xl text-light-slate mt-4">The ultimate destination for digital games.</p>
          </div>
        </div>
      </section>

      <section>
        <h2 className="text-3xl font-bold text-white mb-8">Popular Games</h2>
        <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
          {popularGames.map(game => (
            <GameCard key={game.id} game={game} />
          ))}
        </div>
      </section>

      <section>
        <h2 className="text-3xl font-bold text-white mb-8">New Releases</h2>
        <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
          {newGames.map(game => (
            <GameCard key={game.id} game={game} />
          ))}
        </div>
      </section>
    </div>
  );
};
