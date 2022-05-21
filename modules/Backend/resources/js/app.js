import React from 'react'
import { render } from 'react-dom'
import { createInertiaApp } from '@inertiajs/inertia-react'
import { InertiaProgress } from '@inertiajs/progress'

import '../../../../node_modules/jquery/dist/jquery.min'
import '../../../../node_modules/bootstrap/dist/css/bootstrap.min.css';
import '../assets/plugins/font-awesome/css/font-awesome.min.css';
import '../../../../public/jw-styles/juzaweb/css/backend.min.css';
import '../../../../public/jw-styles/juzaweb/css/custom.min.css';

InertiaProgress.init()

createInertiaApp({
    //id: 'jw-app',
    resolve: name => require(`./Pages/${name}`),
    setup({ el, App, props }) {
        render(<App {...props} />, el)
    },
})
