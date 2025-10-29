// src/layouts/Footer.jsx

export const Footer = () => {
  return (
    <footer className="bg-navy-800 mt-20">
      <div className="container mx-auto px-4 py-8">
        <div className="flex flex-col md:flex-row justify-between items-center">
          <p className="text-light-slate">&copy; {new Date().getFullYear()} GameStore+. All rights reserved.</p>
          <div className="flex gap-4 mt-4 md:mt-0">
            <a href="#" className="text-light-slate hover:text-neon-pink transition-colors">Privacy Policy</a>
            <a href="#" className="text-light-slate hover:text-neon-pink transition-colors">Terms of Service</a>
          </div>
        </div>
      </div>
    </footer>
  );
};
