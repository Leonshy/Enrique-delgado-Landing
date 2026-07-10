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
            colors: {
                primary:   { DEFAULT: '#C86432', light: '#D68B65', dark: '#A0563D' },
                secondary: { DEFAULT: '#D68B65' },
                accent:    { DEFAULT: '#F5DEB3' },
                brand: {
                    dark:  '#3A2115',
                    light: '#FDF8F2',
                    muted: '#FAEFDA',
                },
            },
            fontFamily: {
                sans:  ['Inter', ...defaultTheme.fontFamily.sans],
                serif: ['Playfair Display', ...defaultTheme.fontFamily.serif],
            },
            animation: {
                'fade-in':  'fadeIn 0.6s ease-out',
                'slide-up': 'slideUp 0.6s ease-out',
            },
            keyframes: {
                fadeIn:  { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                slideUp: { '0%': { opacity: '0', transform: 'translateY(20px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
            },
        },
    },
    plugins: [forms, typography],
};
