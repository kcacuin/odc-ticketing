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
            // TODO: Phase 2
            // colors: {
            //     'text': {
            //         50: 'var(--text-50)',
            //         100: 'var(--text-100)',
            //         200: 'var(--text-200)',
            //         300: 'var(--text-300)',
            //         400: 'var(--text-400)',
            //         500: 'var(--text-500)',
            //         600: 'var(--text-600)',
            //         700: 'var(--text-700)',
            //         800: 'var(--text-800)',
            //         900: 'var(--text-900)',
            //         950: 'var(--text-950)',
            //     },
            //     'odc': {
            //         50: 'var(--background-50)',
            //         100: 'var(--background-100)',
            //         200: 'var(--background-200)',
            //         300: 'var(--background-300)',
            //         400: 'var(--background-400)',
            //         500: 'var(--background-500)',
            //         600: 'var(--background-600)',
            //         700: 'var(--background-700)',
            //         800: 'var(--background-800)',
            //         900: 'var(--background-900)',
            //         950: 'var(--background-950)',
            //     },
            //     'odc-primary': {
            //         50: 'var(--primary-50)',
            //         100: 'var(--primary-100)',
            //         200: 'var(--primary-200)',
            //         300: 'var(--primary-300)',
            //         400: 'var(--primary-400)',
            //         500: 'var(--primary-500)',
            //         600: 'var(--primary-600)',
            //         700: 'var(--primary-700)',
            //         800: 'var(--primary-800)',
            //         900: 'var(--primary-900)',
            //         950: 'var(--primary-950)',
            //     },
            //     'odc-secondary': {
            //         50: 'var(--secondary-50)',
            //         100: 'var(--secondary-100)',
            //         200: 'var(--secondary-200)',
            //         300: 'var(--secondary-300)',
            //         400: 'var(--secondary-400)',
            //         500: 'var(--secondary-500)',
            //         600: 'var(--secondary-600)',
            //         700: 'var(--secondary-700)',
            //         800: 'var(--secondary-800)',
            //         900: 'var(--secondary-900)',
            //         950: 'var(--secondary-950)',
            //     },
            //     'odc-accent': {
            //         50: 'var(--accent-50)',
            //         100: 'var(--accent-100)',
            //         200: 'var(--accent-200)',
            //         300: 'var(--accent-300)',
            //         400: 'var(--accent-400)',
            //         500: 'var(--accent-500)',
            //         600: 'var(--accent-600)',
            //         700: 'var(--accent-700)',
            //         800: 'var(--accent-800)',
            //         900: 'var(--accent-900)',
            //         950: 'var(--accent-950)',
            //     },
            // },
            keyframes: {
                wiggle: {
                  '0%, 100%': { transform: 'rotate(-3deg)' },
                  '50%': { transform: 'rotate(3deg)' },
                }
            },
            animation: {
                'spin-slow': 'spin 3s linear infinite',
                'wiggle': 'wiggle 1s ease-in-out infinite',
            }
        },
    },

    plugins: [forms, typography],
};
