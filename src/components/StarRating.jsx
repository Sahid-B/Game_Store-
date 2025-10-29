// src/components/StarRating.jsx
import { Star } from 'lucide-react';
import { cn } from '../lib/utils';

export const StarRating = ({ rating, className }) => {
  return (
    <div className={cn('flex items-center', className)}>
      {[...Array(5)].map((_, i) => (
        <Star
          key={i}
          className={`h-5 w-5 ${i < rating ? 'text-yellow-400 fill-current' : 'text-gray-600'}`}
        />
      ))}
    </div>
  );
};
