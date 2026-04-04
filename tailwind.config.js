import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './resources/js/**/*.jsx',
        './resources/js/**/*.tsx',
    ],

    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
                headline: ["Newsreader", "serif"],
                body: ["Public Sans", "sans-serif"],
                label: ["Public Sans", "sans-serif"]
            },
            colors: {
                // New Theme Colors
                "outline": "#76777d",
                "on-secondary-fixed": "#40000c",
                "on-surface": "#191c1e",
                "surface-container-high": "#e6e8ea",
                "secondary-fixed-dim": "#ffb3b6",
                "outline-variant": "#c6c6cd",
                "surface-tint": "#565e74",
                "surface-container": "#eceef0",
                "on-primary-fixed-variant": "#3f465c",
                "on-tertiary-container": "#497cff",
                "surface-dim": "#d8dadc",
                "surface": "#f7f9fb",
                "tertiary-fixed-dim": "#b4c5ff",
                "secondary-container": "#e21e49",
                "on-surface-variant": "#45464d",
                "surface-variant": "#e0e3e5",
                "surface-container-lowest": "#ffffff",
                "on-secondary-fixed-variant": "#920028",
                "on-primary-fixed": "#131b2e",
                "tertiary-fixed": "#dbe1ff",
                "tertiary": "#000000",
                "primary": "#000000",
                "inverse-primary": "#bec6e0",
                "primary-fixed-dim": "#bec6e0",
                "on-background": "#191c1e",
                "on-primary-container": "#7c839b",
                "secondary-fixed": "#ffdada",
                "surface-container-highest": "#e0e3e5",
                "background": "#f7f9fb",
                "on-secondary": "#ffffff",
                "surface-container-low": "#f2f4f6",
                "on-tertiary": "#ffffff",
                "on-secondary-container": "#fffbff",
                "tertiary-container": "#00174b",
                "on-error": "#ffffff",
                "on-primary": "#ffffff",
                "inverse-surface": "#2d3133",
                "primary-container": "#131b2e",
                "on-tertiary-fixed-variant": "#003ea8",
                "inverse-on-surface": "#eff1f3",
                "error-container": "#ffdad6",
                "secondary": "#a53a3a",
                "on-tertiary-fixed": "#00174b",
                "error": "#ba1a1a",
                "on-error-container": "#93000a",
                "primary-fixed": "#dae2fd",
                "surface-bright": "#f7f9fb",
                
                // Existing compatibility colors
                border: "hsl(var(--border))",
                input: "hsl(var(--input))",
                ring: "hsl(var(--ring))",
                foreground: "hsl(var(--foreground))",
                destructive: {
                    DEFAULT: "hsl(var(--destructive))",
                    foreground: "hsl(var(--destructive-foreground))",
                },
                muted: {
                    DEFAULT: "hsl(var(--muted))",
                    foreground: "hsl(var(--muted-foreground))",
                },
                accent: {
                    DEFAULT: "hsl(var(--accent))",
                    foreground: "hsl(var(--accent-foreground))",
                },
                popover: {
                    DEFAULT: "hsl(var(--popover))",
                    foreground: "hsl(var(--popover-foreground))",
                },
                card: {
                    DEFAULT: "hsl(var(--card))",
                    foreground: "hsl(var(--card-foreground))",
                },
                current: 'currentColor',
                transparent: 'transparent',
                whiter: '#F5F7FD',
                boxdark: '#24303F',
                'boxdark-2': '#1A222C',
                strokedark: '#2E3A47',
                success: '#219653',
                danger: '#D34053',
                warning: '#FFA70B',
            },
            borderRadius: {
                lg: "var(--radius)",
                md: "calc(var(--radius) - 2px)",
                sm: "calc(var(--radius) - 4px)",
                DEFAULT: "0.125rem",
                xl: "0.5rem",
                full: "0.75rem"
            },
        },
    },

    plugins: [forms],
};
