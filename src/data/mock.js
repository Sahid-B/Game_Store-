// src/data/mock.js

export const games = [
    {
      id: 1,
      title: "Cyberpunk 2077",
      description: "An open-world, action-adventure story set in Night City, a megalopolis obsessed with power, glamour and body modification.",
      price: 59.99,
      genre: "RPG",
      rating: 4,
      image: "/images/games/cyberpunk.jpg",
      screenshots: ["/images/screenshots/cyberpunk1.jpg", "/images/screenshots/cyberpunk2.jpg", "/images/screenshots/cyberpunk3.jpg"],
      reviews: [
        { user: "PlayerOne", rating: 5, comment: "Incredible world and story!" },
        { user: "GamerGirl", rating: 4, comment: "A bit buggy, but amazing experience." },
      ],
      tags: ["new", "popular"]
    },
    // ... add 29 more games
  ];

  export const users = [
    {
      id: 1,
      name: "Admin User",
      email: "admin@gamestore.com",
      role: "admin",
      avatar: "/images/avatars/admin.png",
      purchaseHistory: [/* ... */],
    },
    {
      id: 2,
      name: "John Doe",
      email: "john@gamestore.com",
      role: "user",
      avatar: "/images/avatars/user.png",
      purchaseHistory: [/* ... */],
    },
  ];

  export const genres = ["RPG", "Action", "Adventure", "Strategy", "Simulation"];
