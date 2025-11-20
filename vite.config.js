import laravel from 'laravel-vite-plugin';
import * as path from "node:path";
import {defineConfig} from "vite";
import inject from '@rollup/plugin-inject';

export default defineConfig({
    base: './',
    build: {
        minify: true,
    },
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap')
        }
    },
    plugins: [
        // Injects jquery as a global variable
        inject({
            $: 'jquery',
            jQuery: 'jquery',
            exclude: ['**/*.scss']
        }),
        laravel({
            input: [
                'resources/assets/sass/app.scss',
                'resources/assets/js/app.js'
            ],
            refresh: true,
        })
    ]
});