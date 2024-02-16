import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'blue-primary': '#0F2B3C',
                'blue-secondary': '#205375',
                'red': '#ED1C24',
                'gray-primary': '#D9D9D9',
                'gray-dark': '#273444',
                'gray': '#8492a6',
                'gray-light': '#F0EFEF',
            },
        },
    },

    plugins: [forms, typography],
};
