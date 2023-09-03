import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import path from "path";
import purge from '@erbelion/vite-plugin-laravel-purgecss';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.tsx', 'vendor/juzaweb/modules/resources/css/app.scss'],
            refresh: true,
        }),
        // purge({
        //     paths: [
        //         'vendor/juzaweb/modules/resources/views/**/*.blade.php',
        //         'vendor/juzaweb/modules/resources/js/**/*.tsx',
        //     ],
        //     safelist: {
        //         standard: [/fa-(.*)$/],
        //     }
        // }),
        react(),
    ],
    build: {
        outDir: path.resolve(__dirname, 'public/jw-styles/juzaweb/build'),
    },
    resolve: {
        preserveSymlinks: true,
        alias: {
            '@': path.resolve(__dirname + '/vendor/juzaweb/modules/resources/js'),
        },
    },
    experimental: {
        renderBuiltUrl(filename, {hostId, hostType, type}) {
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
