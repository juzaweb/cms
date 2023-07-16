// import React from 'react';
// import { render } from 'react-dom';
// import { createInertiaApp } from '@inertiajs/react';
// import {InertiaProgress} from "@inertiajs/progress";
//
// InertiaProgress.init();
//
// createInertiaApp({
//     //id: 'juzaweb-app',
//     resolve: name => import(`./pages/${name}`),
//     setup({el, App, props}) {
//         render(<App {...props} />, el)
//     },
// });

import { createInertiaApp } from '@inertiajs/react'
//import { createRoot } from 'react-dom/client'
import { hydrateRoot } from 'react-dom/client'

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./pages/**/*.tsx', { eager: true })
        return pages[`./pages/${name}.tsx`]
    },
    setup({ el, App, props }) {
        //createRoot(el).render(<App {...props} />)
        hydrateRoot(el, <App {...props} />)
    },
})
