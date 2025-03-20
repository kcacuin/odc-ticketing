import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
// import nightwind from 'nightwind';

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
                'background': 'rgba(var(--background))',
                'primary-background': 'rgba(var(--primary-background))',
                'secondary-background': 'rgba(var(--secondary-background))',

                'primary': 'rgba(var(--primary))',
                'secondary': 'rgba(var(--secondary))',
                
                'cta': 'rgba(var(--cta))',
                'cta-hover': 'rgba(var(--cta-hover))',
                'cta-active': 'rgba(var(--cta-active))',
                'cta-border': 'rgba(var(--cta-border))',
                'cta-text': 'rgba(var(--cta-text))',
                'cta-accent': 'rgba(var(--cta-accent))',
                
                'border': 'rgba(var(--border))',
                'nav-border': 'rgba(var(--nav-border))',
                
                'text': 'rgba(var(--text))',
                'text-placeholder': 'rgba(var(--text-placeholder))',
                
                'row': 'rgba(var(--row))',
                'row-active': 'rgba(var(--row-active))',

                'stat-bg-red': 'rgba(var(--stat-bg-red))',
                'stat-bg-blue': 'rgba(var(--stat-bg-blue))',
                'stat-bg-yellow': 'rgba(var(--stat-bg-yellow))',
                'stat-bg-purple': 'rgba(var(--stat-bg-purple))',
                'stat-bg-green': 'rgba(var(--stat-bg-green))',

                'stat-text-red': 'rgba(var(--stat-text-red))',
                'stat-text-blue': 'rgba(var(--stat-text-blue))',
                'stat-text-yellow': 'rgba(var(--stat-text-yellow))',
                'stat-text-purple': 'rgba(var(--stat-text-purple))',
                'stat-text-green': 'rgba(var(--stat-text-green))',
   
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
        // nightwind: {
        //     colorClasses: [
        //       "gradient",
        //       "ring",
        //       "ring-offset",
        //       "divide",
        //       "placeholder",
        //     ],
        //     transitionClasses: "full",
        // },
    },

    // variants: {
    //     nightwind: ["focus"],
    // },

    // darkMode: "class",
    // plugins: [forms, typography, nightwind],
    plugins: [forms, typography],
};
