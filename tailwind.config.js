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
            colors: {
                'primary-rose': '#F3C5C5',
                'secondary-blush': '#FCEAEA',
                'bg-cream': '#FFF8F8',
                'text-charcoal': '#2D2727',
            },
            fontFamily: {
                sans: ['Quicksand', ...defaultTheme.fontFamily.sans],
                display: ['Fredoka', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
