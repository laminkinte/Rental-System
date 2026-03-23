/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        // Tailwind Pink colors
        'pink': {
          50: '#fdf2f8',
          100: '#fce7f3',
          200: '#fbcfe8',
          300: '#f9a8d4',
          400: '#f472b6',
          500: '#ec4899',
          600: '#db2777',
          700: '#be185d',
          800: '#9d174d',
          900: '#831843',
        },
        // Airbnb Brand Colors
        'airbnb-pink': '#FF5A5F',
        'airbnb-pink-dark': '#FF385C',
        'airbnb-pink-light': '#FF7E82',
        'airbnb-gray': '#484848',
        'airbnb-gray-light': '#767676',
        'airbnb-gray-extra-light': '#EBEBEB',
        'airbnb-black': '#222222',
        'airbnb-red': '#C13524',
        // Additional neutrals
        'gray-50': '#F7F7F7',
        'gray-100': '#EBEBEB',
        'gray-200': '#DFDFDF',
        'gray-300': '#C4C4C4',
        'gray-400': '#A0A0A0',
        'gray-500': '#767676',
        'gray-600': '#484848',
        'gray-700': '#383838',
        'gray-800': '#222222',
      },
      fontFamily: {
        'sans': ['Airbnb', 'Circular', '-apple-system', 'BlinkMacSystemFont', 'Roboto', 'Helvetica Neue', 'sans-serif'],
      },
      borderRadius: {
        'xl': '12px',
        '2xl': '16px',
        '3xl': '24px',
        'full': '9999px',
      },
      boxShadow: {
        'airbnb': '0 1px 2px rgba(0, 0, 0, 0.08), 0 4px 12px rgba(0, 0, 0, 0.05)',
        'airbnb-hover': '0 2px 4px rgba(0, 0, 0, 0.1), 0 8px 16px rgba(0, 0, 0, 0.1)',
        'airbnb-card': '0 6px 16px rgba(0, 0, 0, 0.12)',
      },
      spacing: {
        '18': '4.5rem',
        '88': '22rem',
        '120': '30rem',
      },
      fontSize: {
        '2xs': ['0.625rem', { lineHeight: '1rem' }],
      },
      animation: {
        'fade-in': 'fadeIn 0.3s ease-in-out',
        'slide-up': 'slideUp 0.3s ease-out',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideUp: {
          '0%': { opacity: '0', transform: 'translateY(10px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
      },
    },
  },
  plugins: [],
}
