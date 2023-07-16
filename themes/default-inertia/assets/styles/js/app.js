import React from 'react';
import { render } from 'react-dom';
import { createInertiaApp } from '@inertiajs/react';
import {InertiaProgress} from "@inertiajs/progress";

InertiaProgress.init();

createInertiaApp({
    //id: 'juzaweb-app',
    resolve: name => import(`./pages/${name}`),
    setup({el, App, props}) {
        render(<App {...props} />, el)
    },
});
