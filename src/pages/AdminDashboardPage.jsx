// src/pages/AdminDashboardPage.jsx
import { useAuth } from '../contexts/AuthContext';
import { Navigate } from 'react-router-dom';
import { Link } from 'react-router-dom';
import { users, games } from '../data/mock';
import { BarChart, Users, DollarSign, ShoppingCart } from 'lucide-react';

export const AdminDashboardPage = () => {
  const { currentUser } = useAuth();

  if (!currentUser || currentUser.role !== 'admin') {
    return <Navigate to="/login" />;
  }

  // Mock data for stats
  const totalSales = 12543.50;
  const newUsers = 23;
  const ordersToday = 42;

  return (
    <div className="space-y-8">
      <h1 className="text-3xl font-bold">Admin Dashboard</h1>
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <StatCard icon={<DollarSign />} title="Total Sales" value={`$${totalSales.toLocaleString()}`} />
        <StatCard icon={<Users />} title="New Users" value={newUsers} />
        <StatCard icon={<ShoppingCart />} title="Orders Today" value={ordersToday} />
        <StatCard icon={<BarChart />} title="Weekly Report" value="View" isLink="/admin/reports" />
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div className="lg:col-span-2 bg-navy-800 p-6 rounded-lg">
          <h2 className="text-xl font-bold mb-4">Sales Chart (Last 7 Days)</h2>
          {/* Chart component would go here */}
          <div className="h-64 bg-navy-900 rounded-md flex items-center justify-center">
            <p>Chart Placeholder</p>
          </div>
        </div>
        <div className="bg-navy-800 p-6 rounded-lg">
          <h2 className="text-xl font-bold mb-4">Top Selling Games</h2>
          <ul className="space-y-4">
            {games.slice(0, 5).map(game => (
              <li key={game.id} className="flex items-center">
                <img src={game.image} alt={game.title} className="w-12 h-12 rounded-md" />
                <div className="ml-4">
                  <p className="font-bold">{game.title}</p>
                  <p className="text-sm text-light-slate">${game.price}</p>
                </div>
              </li>
            ))}
          </ul>
        </div>
      </div>

      <div className="mt-8">
          <Link to="/admin/users" className="text-neon-pink hover:underline">Manage Users &rarr;</Link>
      </div>
    </div>
  );
};

const StatCard = ({ icon, title, value, isLink }) => (
  <div className="bg-navy-800 p-6 rounded-lg flex items-center gap-6">
    <div className="bg-navy-900 p-3 rounded-full">{icon}</div>
    <div>
      <p className="text-light-slate">{title}</p>
      {isLink ? (
        <Link to={isLink} className="text-2xl font-bold hover:underline">{value}</Link>
      ) : (
        <p className="text-2xl font-bold">{value}</p>
      )}
    </div>
  </div>
);
