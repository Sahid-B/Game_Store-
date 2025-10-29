// src/components/Toast.jsx
import { CheckCircle, XCircle, AlertTriangle } from 'lucide-react';

const icons = {
  success: <CheckCircle className="h-6 w-6 text-green-400" />,
  error: <XCircle className="h-6 w-6 text-red-400" />,
  warning: <AlertTriangle className="h-6 w-6 text-yellow-400" />,
};

export const Toast = ({ message, type }) => {
  return (
    <div className="flex items-center bg-navy-800 text-white p-4 rounded-lg shadow-lg mb-2">
      {icons[type]}
      <p className="ml-3">{message}</p>
    </div>
  );
};
