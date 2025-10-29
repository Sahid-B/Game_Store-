// src/components/Input.jsx
import React from 'react';
import { cn } from '../lib/utils';

const Input = React.forwardRef(({ className, ...props }, ref) => {
  return (
    <input
      className={cn(
        'flex h-10 w-full rounded-md border border-navy-800 bg-navy-900 px-3 py-2 text-sm text-light-slate placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neon-pink focus:ring-offset-navy-900',
        className
      )}
      ref={ref}
      {...props}
    />
  );
});

export { Input };
