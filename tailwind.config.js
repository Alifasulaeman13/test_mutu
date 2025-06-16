/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#f0f9f8',
          100: '#dcf2f0',
          200: '#bae5e2',
          300: '#8ed1cd',
          400: '#5db5b1',
          500: '#007774',
          600: '#006663',
          700: '#005352',
          800: '#004342',
          900: '#003736',
        },
      },
    },
  },
  plugins: [],
} 