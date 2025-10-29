// src/pages/CatalogPage.jsx
import { useState } from 'react';
import { GameCard } from '../components/GameCard';
import { games, genres } from '../data/mock';
import { Input } from '../components/Input';
import { Button } from '../components/Button';

export const CatalogPage = () => {
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedGenres, setSelectedGenres] = useState([]);
  const [priceRange, setPriceRange] = useState(100);

  const filteredGames = games.filter(game => {
    const matchesSearch = game.title.toLowerCase().includes(searchTerm.toLowerCase());
    const matchesGenre = selectedGenres.length === 0 || selectedGenres.includes(game.genre);
    const matchesPrice = game.price <= priceRange;
    return matchesSearch && matchesGenre && matchesPrice;
  });

  const handleGenreChange = (genre) => {
    setSelectedGenres(prev =>
      prev.includes(genre) ? prev.filter(g => g !== genre) : [...prev, genre]
    );
  };

  return (
    <div className="flex flex-col md:flex-row gap-8">
      <aside className="w-full md:w-1/4">
        <div className="bg-navy-800 p-6 rounded-lg">
          <h3 className="text-xl font-bold mb-4">Filters</h3>
          <div className="space-y-6">
            <div>
              <label className="font-semibold mb-2 block">Search</label>
              <Input
                type="text"
                placeholder="Search games..."
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
              />
            </div>
            <div>
              <label className="font-semibold mb-2 block">Price Range: ${priceRange}</label>
              <input
                type="range"
                min="0"
                max="100"
                value={priceRange}
                onChange={(e) => setPriceRange(e.target.value)}
                className="w-full"
              />
            </div>
            <div>
              <h4 className="font-semibold mb-2">Genres</h4>
              <div className="space-y-2">
                {genres.map(genre => (
                  <label key={genre} className="flex items-center">
                    <input
                      type="checkbox"
                      className="form-checkbox"
                      checked={selectedGenres.includes(genre)}
                      onChange={() => handleGenreChange(genre)}
                    />
                    <span className="ml-2">{genre}</span>
                  </label>
                ))}
              </div>
            </div>
          </div>
        </div>
      </aside>
      <main className="w-full md:w-3/4">
        <h1 className="text-3xl font-bold mb-8">Game Catalog</h1>
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
          {filteredGames.map(game => (
            <GameCard key={game.id} game={game} />
          ))}
        </div>
      </main>
    </div>
  );
};
