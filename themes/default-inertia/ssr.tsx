import ReactDOMServer from 'react-dom/server';
import {createInertiaApp} from '@inertiajs/react';
import createServer from '@inertiajs/react/server';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import axios from "axios";
//import route from '../../vendor/tightenco/ziggy/dist/index.m';

axios.interceptors.request.use((config) => {
    config.headers['Content-Type'] = 'application/json';
    return config;
});

createServer((page) =>
    createInertiaApp({
        page,
        render: ReactDOMServer.renderToString,
        title: (title) => `${title}`,
        resolve: (name) => resolvePageComponent(`./views/${name}.tsx`, import.meta.glob('./views/**/*.tsx')),
        setup: ({App, props}) => {
            return <App {...props} />;
        },
    })
);
