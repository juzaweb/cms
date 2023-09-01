import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import path from "path";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.tsx', 'vendor/juzaweb/modules/resources/css/app.css'],
            refresh: true,
        }),
        react(),
    ],
    build: {
        outDir: path.resolve(__dirname, 'public/jw-styles/juzaweb/build'),
    },
    resolve: {
        preserveSymlinks: true,
        alias: {
            '@': path.resolve(__dirname + '/vendor/juzaweb/modules/resources/js'),
            '@plugins': path.resolve(__dirname + '/plugins'),
        },
    },
    experimental: {
        renderBuiltUrl(filename, { hostId, hostType, type }) {
            // if (type === 'public') {
            //     return 'https://www.domain.com/' + filename
            // }
            // else if (path.extname(hostId) === '.js') {
            //     return { runtime: `window.__assetsPath(${JSON.stringify(filename)})` }
            // }
            // else {
            //     return 'https://cdn.domain.com/assets/' + filename
            // }
            return `/jw-styles/juzaweb/build/${filename}`
        }
    }
});
