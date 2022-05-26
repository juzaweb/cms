import React from 'react'
import { render } from 'react-dom'
import { createInertiaApp } from '@inertiajs/inertia-react'
import { InertiaProgress } from '@inertiajs/progress'

import '../../../../public/jw-styles/juzaweb/css/vendor.min.css';
import '../../../../public/jw-styles/juzaweb/css/backend.min.css';
import '../../../../public/jw-styles/juzaweb/css/custom.min.css';

InertiaProgress.init()

createInertiaApp(
    {
        resolve: name => require(`./Pages/${name}`),
        setup({ el, App, props }) {
            render(<App {...props} />, el)
        },
    }
);
