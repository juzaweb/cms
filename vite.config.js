import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import path from "path";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.tsx', 'resources/css/app.css'],
            //ssr: 'resources/js/ssr.tsx',
            refresh: true,
        }),
        react(),
    ],
    build: {
        outDir: path.resolve(__dirname, 'Backend/resources/assets/public/build'),
    },
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    }
});
