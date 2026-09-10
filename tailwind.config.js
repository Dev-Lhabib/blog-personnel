import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['DM Sans', ...defaultTheme.fontFamily.sans],
                display: ['Newsreader', 'DM Sans', ...defaultTheme.fontFamily.serif],
            },
            boxShadow: {
                soft: '0 1px 2px rgb(16 24 40 / 0.04), 0 8px 24px -12px rgb(16 24 40 / 0.18)',
                card: '0 1px 3px rgb(16 24 40 / 0.08), 0 12px 32px -16px rgb(79 70 229 / 0.25)',
            },
            animation: {
                'fade-up': 'fadeUp .7s cubic-bezier(.22,1,.36,1) both',
            },
            keyframes: {
                fadeUp: {
                    from: { opacity: '0', transform: 'translateY(14px)' },
                    to: { opacity: '1', transform: 'translateY(0)' },
                },
            },
        },
    },

    plugins: [forms],
};
