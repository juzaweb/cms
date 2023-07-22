import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['themes/default-inertia/app.tsx', 'themes/default-inertia/app.css'],
            ssr: 'themes/default-inertia/ssr.tsx',
            refresh: true,
        }),
        react(),
    ],
    build: {
        outDir: path.resolve(__dirname, 'assets/build'),
    },
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    },
});
