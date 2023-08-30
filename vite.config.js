import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import path from "path";

export default defineConfig({
    plugins: [
        laravel({
            input: ['vendor/juzaweb/modules/resources/js/app.tsx', 'vendor/juzaweb/modules/resources/css/app.css'],
            refresh: true,
        }),
        react(),
    ],
    build: {
        outDir: path.resolve(__dirname, 'vendor/juzaweb/modules/assets/public/build'),
    },
    resolve: {
        alias: {
            '@': '/vendor/juzaweb/modules/resources/js',
        },
    },
    experimental: {
        renderBuiltUrl(filename, { hostId, hostType, type }) {
            return '/jw-styles/juzaweb/build/' + filename
        }
    }
});
