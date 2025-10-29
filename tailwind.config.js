/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        'navy': {
          '900': '#0a192f',
          '800': '#1e2a47',
        },
        'neon-pink': '#ff007f',
        'light-slate': '#ccd6f6',
      },
      fontFamily: {
        'sans': ['"Poppins"', 'sans-serif'],
      },
    },
  },
  plugins: [],
}
