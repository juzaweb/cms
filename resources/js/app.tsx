import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import axios from "axios";
// For old js
// import jQuery from '@types/jquery';
// import Popper from "popper.js";
// import $ from "jquery";
import 'bootstrap';
// import Chart from 'chart.js/auto';
//
// declare global {
//     interface Window {
//         jQuery: typeof jQuery;
//         $: typeof jQuery;
//         Chart: typeof Chart;
//         Popper: typeof Popper;
//     }
// }
//
// window.$ = window.jQuery = $;
// window.Popper = Popper;
// window.Chart = Chart;

// Config axios
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
