import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Montserrat', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    navy: '#263b5c',
                    'navy-dark': '#1a2a42',
                    gold: '#f8b400',
                    'gold-dark': '#d99c00',
                    mist: '#edf0f5',
                },
            },
        },
    },

    plugins: [forms],
};
