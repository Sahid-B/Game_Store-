// src/pages/ProfilePage.jsx
import { useAuth } from '../contexts/AuthContext';
import { Navigate } from 'react-router-dom';
import { Button } from '../components/Button';
import { Input } from '../components/Input';

export const ProfilePage = () => {
  const { currentUser } = useAuth();

  if (!currentUser) {
    return <Navigate to="/login" />;
  }

  return (
    <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div className="md:col-span-1">
        <div className="bg-navy-800 p-6 rounded-lg text-center">
          <img src={currentUser.avatar} alt={currentUser.name} className="w-32 h-32 rounded-full mx-auto mb-4" />
          <h2 className="text-2xl font-bold">{currentUser.name}</h2>
          <p className="text-light-slate">{currentUser.email}</p>
        </div>
      </div>
      <div className="md:col-span-2">
        <div className="bg-navy-800 p-6 rounded-lg">
          <h3 className="text-xl font-bold mb-4">Edit Profile</h3>
          <div className="space-y-4">
            <Input defaultValue={currentUser.name} />
            <Input type="email" defaultValue={currentUser.email} />
            <Button>Save Changes</Button>
          </div>
        </div>
        <div className="bg-navy-800 p-6 rounded-lg mt-8">
          <h3 className="text-xl font-bold mb-4">Purchase History</h3>
          {/* Mock data - in a real app, this would come from user data */}
          <p>No purchases yet.</p>
        </div>
      </div>
    </div>
  );
};
