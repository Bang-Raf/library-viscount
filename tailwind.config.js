/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./app/Livewire/**/*.php",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", "ui-sans-serif", "system-ui", "sans-serif"],
            },
        },
    },
    plugins: [require("@tailwindcss/forms")],
};
