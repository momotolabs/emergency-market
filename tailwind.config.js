/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    './vendor/filament/**/*.blade.php',
  ],
  theme: {
    extend: {
      colors: {
        primary: '#0F4BAD',
        secondary: '#FA5B46',
        error: '#EA3434',
        success: '#00BA88',
        warning: '#F4B740',
        'title-active': '#14142B',
        body: '#4E4B66',
        label: '#6E7191',
        placeholder: '#A0A3BD',
        line: '#D9DBE9',
        input: {
          background: '#EFF0F7',
        },
        background: '#F7F7FC',
        'off-white': '#FCFCFC',
        lightgreen: "#9ACA3C",
      },
      fontFamily: {
        'inter': ['Inter', 'sans-serif']
      }
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
};
