/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        bgBase: '#f1f5f9',
        bgSurface: 'rgba(255, 255, 255, 0.7)',
        bgCard: 'rgba(255, 255, 255, 0.4)',
        primary: {
          DEFAULT: '#6EE7B7', // Mint Green
          hover: '#34D399',
          glow: 'rgba(110, 231, 183, 0.15)',
        },
        accent: {
          DEFAULT: '#34D399',
          glow: 'rgba(52, 211, 153, 0.1)',
        },
        textPrimary: '#0f172a',
        textSecondary: '#334155',
        textMuted: '#64748b',
        borderLight: 'rgba(15, 23, 42, 0.08)',
      },
      fontFamily: {
        heading: ['Outfit', 'Inter', 'sans-serif'],
        body: ['Inter', 'sans-serif'],
      },
      boxShadow: {
        glass: '0 8px 32px 0 rgba(31, 38, 135, 0.07)',
      }
    },
  },
  plugins: [],
}
