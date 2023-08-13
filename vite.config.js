import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import path from "path";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.tsx', 'resources/css/app.css'],
            refresh: true,
        }),
        react(),
    ],
    build: {
        outDir: path.resolve(__dirname, 'modules/Backend/resources/assets/public/build'),
    },
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    },
    experimental: {
        renderBuiltUrl(filename, { hostId, hostType, type }) {
            return '/jw-styles/juzaweb/build/' + filename
        }
    }
});
