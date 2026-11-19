import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from 'tailwindcss';
import autoprefixer from 'autoprefixer';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/sass/custom.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    css: {
        postcss: {
            plugins: [
                tailwindcss('./tailwind.config.js'),
                autoprefixer(),
            ],
        },
        lightningcss: {
            errorRecovery: true,
        },
        preprocessorOptions: {
            scss: {
                quietDeps: true,
                silenceDeprecations: ['import', 'slash-div', 'global-builtin'],
            },
        },
    },
});
