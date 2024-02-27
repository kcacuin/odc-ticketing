import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import importCss from 'vite-plugin-import-css';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        importCss(),
    ],
});
