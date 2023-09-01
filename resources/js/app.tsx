import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import axios from "axios";

axios.interceptors.request.use((config) => {
    config.headers['Content-Type'] = 'application/json';
    return config;
});

createInertiaApp({
    title: (title) => title,
    resolve: (name) => {
        let page = null;
        let isModule = name.split("::");
        let moduleName = isModule[0];
        let pathToFile = isModule[1];

        if (moduleName !== 'cms') {
            page = resolvePageComponent(
                `../../plugins/${moduleName}/src/resources/js/pages/${pathToFile}.tsx`,
                import.meta.glob(`../../plugins/*/src/resources/js/pages/**/*.tsx`)
            );
        } else {
            page = resolvePageComponent(
                `../../vendor/juzaweb/modules/resources/js/pages/${pathToFile}.tsx`,
                import.meta.glob('../../vendor/juzaweb/modules/resources/js/pages/**/*.tsx')
            );
        }

        return page;
    },
    setup({ el, App, props }) {
        const root = createRoot(el);

        root.render(<App {...props} />);
    },
    progress: {
        color: '#4B5563',
    },
});
