// tailwind.config.js
import defaultTheme from 'tailwindcss/defaultTheme';

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
                // Custom NFL Pick'em League colors
                'soft': '#F2EBBF',        // cream/beige background
                'primary': '#5C4B51',     // dark brown text
                'tomato': '#F06060',      // red accent
                'highlight': '#F3B562',   // orange/yellow highlight
                'card': '#FFFFFF',        // white cards
            }
        },
    },

};
