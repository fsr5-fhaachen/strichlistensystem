const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  purge: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue'
  ],
  purge: false,
  darkMode: 'media',
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter var', ...defaultTheme.fontFamily.sans],
      },
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
