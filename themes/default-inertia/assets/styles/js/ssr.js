import React from 'react'
import ReactDOMServer from 'react-dom/server'
import { createInertiaApp } from '@inertiajs/inertia-react'
import createServer from '@inertiajs/server'

createServer((page) => createInertiaApp({
    page,
    render: ReactDOMServer.renderToString,
    resolve: name => import(`./pages/${name}`),
    setup: ({ App, props }) => <App {...props} />,
}));
