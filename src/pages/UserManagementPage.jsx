// src/pages/UserManagementPage.jsx
import { useAuth } from '../contexts/AuthContext';
import { Navigate } from 'react-router-dom';
import { users } from '../data/mock';
import { Input } from '../components/Input';
import { Button } from '../components/Button';
import { Edit, Trash2 } from 'lucide-react';

export const UserManagementPage = () => {
  const { currentUser } = useAuth();

  if (!currentUser || currentUser.role !== 'admin') {
    return <Navigate to="/login" />;
  }

  return (
    <div className="space-y-8">
      <h1 className="text-3xl font-bold">User Management</h1>
      <div className="bg-navy-800 p-6 rounded-lg">
        <div className="flex justify-between items-center mb-4">
          <Input placeholder="Search users..." className="max-w-xs" />
          <Button>Add User</Button>
        </div>
        <div className="overflow-x-auto">
          <table className="w-full text-left">
            <thead>
              <tr className="border-b border-navy-900">
                <th className="p-4">ID</th>
                <th className="p-4">Name</th>
                <th className="p-4">Email</th>
                <th className="p-4">Role</th>
                <th className="p-4 text-right">Actions</th>
              </tr>
            </thead>
            <tbody>
              {users.map(user => (
                <tr key={user.id} className="border-b border-navy-900">
                  <td className="p-4">{user.id}</td>
                  <td className="p-4">{user.name}</td>
                  <td className="p-4">{user.email}</td>
                  <td className="p-4">{user.role}</td>
                  <td className="p-4 flex justify-end gap-2">
                    <Button size="sm" variant="secondary"><Edit className="h-4 w-4" /></Button>
                    <Button size="sm" variant="outline"><Trash2 className="h-4 w-4" /></Button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
};
