import laravel from 'laravel-vite-plugin';
import * as path from "node:path";
import {defineConfig} from "vite";
import commonjs from "vite-plugin-commonjs";
import inject from '@rollup/plugin-inject';

export default defineConfig({
    build: {
        minify: false,

    },
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap')
        }
    },
    plugins: [
        commonjs(),
        inject({
            $: 'jquery',
            jQuery: 'jquery',
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