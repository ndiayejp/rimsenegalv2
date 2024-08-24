/** @type {import('tailwindcss').Config} */
module.exports = {
content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js"
    ],
  theme: {
    extend: {
        colors:{
            yellow:'#FEF029',
            "blue":"#008dcf"
        },
        fontFamily:{
            "hanken-grotest":["Hanken Grotesk", "sans-serif"]
        }
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
}

