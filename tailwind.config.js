/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {
      fontFamily: {
          heading: ['Poiret One', 'sans-serif'],
      },
      colors: {
        primary: 'var(--color-primary)',
        secondary: 'var(--color-secondary)',
        success: '#D3DB4E',
        warning: '#FFC01F',
        danger: '#E94233',
      }
    },
  },
  plugins: [],
}
