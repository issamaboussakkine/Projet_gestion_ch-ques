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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
    'navy': '#071952',
    'teal': '#0B666A',
    'mint': '#35A29F',
    'sea': '#97FEED',
    'warning': '#f59e0b',
    'success': '#22c55e',
}
        },
    },

    plugins: [forms],
};