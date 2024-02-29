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
                'red-primary': '#ED1C24',
                'gray-primary': '#D9D9D9',
                'gray-dark': '#273444',
                'gray': '#8492a6',
                'gray-light': '#F0EFEF',
                'odc-blue': {
                    '50': '#eefbfd',
                    '100': '#d5f2f8',
                    '200': '#afe5f2',
                    '300': '#79d1e7',
                    '400': '#3ab2d6',
                    '500': '#1f95bb',
                    '600': '#1c799e',
                    '700': '#1e6280',
                    '800': '#215169',
                    '900': '#1f445a',
                    '950': '#0f2b3c',
                },
                'odc-red': {
                    '50': '#fff1f2',
                    '100': '#ffdfe0',
                    '200': '#ffc5c7',
                    '300': '#ff9da1',
                    '400': '#ff656b',
                    '500': '#fe353d',
                    '600': '#ed1c24',
                    '700': '#c70e15',
                    '800': '#a41016',
                    '900': '#881418',
                    '950': '#4a0508',
                },

            },
        },
    },

    plugins: [forms, typography],
};
