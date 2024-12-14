import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js"
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
        colors:{
            black:'#060606',
            primary: '#008dcf',
            secondary: '#fff02a',
        },
        fontFamily:{
            "hanken-grotest":["Jost","Hanken Grotesk", "sans-serif"]
        },
    },

    plugins: [forms,  require('flowbite/plugin')],
};
