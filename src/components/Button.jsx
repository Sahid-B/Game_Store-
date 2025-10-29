// src/components/Button.jsx
import React from 'react';
import { cva } from 'class-variance-authority';
import { cn } from '../lib/utils'; // I'll create this utility file next

const buttonVariants = cva(
  'inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neon-pink disabled:opacity-50 disabled:pointer-events-none',
  {
    variants: {
      variant: {
        default: 'bg-neon-pink text-white hover:bg-neon-pink/90',
        secondary: 'bg-navy-800 text-light-slate hover:bg-navy-800/80',
        outline: 'border border-neon-pink text-neon-pink hover:bg-neon-pink hover:text-white',
        ghost: 'hover:bg-navy-800 hover:text-light-slate',
      },
      size: {
        default: 'h-10 py-2 px-4',
        sm: 'h-9 px-3 rounded-md',
        lg: 'h-11 px-8 rounded-md',
      },
    },
    defaultVariants: {
      variant: 'default',
      size: 'default',
    },
  }
);

const Button = React.forwardRef(({ className, variant, size, ...props }, ref) => {
  return (
    <button
      className={cn(buttonVariants({ variant, size, className }))}
      ref={ref}
      {...props}
    />
  );
});

export { Button, buttonVariants };
