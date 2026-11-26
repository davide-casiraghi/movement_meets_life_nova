import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/sass/custom.scss',
                'resources/js/app.js',
                'resources/js/gestionale-calendar.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    css: {
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
    server: {
        proxy: {
            '/webfonts': 'http://movement-meets-life-nova.test',
            '/images': 'http://movement-meets-life-nova.test',
            '/vendor/slick': 'http://movement-meets-life-nova.test',
        },
    },
});
