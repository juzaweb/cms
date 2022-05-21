import React from 'react'
import Layout from '../Layout'
import { usePage } from "@inertiajs/inertia-react";
import Parser from 'html-react-parser';

const BladeRender = () => {
    const { content } = usePage().props;

    return (
        <>
            {Parser(content)}
        </>
    )
}

BladeRender.layout = page => <Layout children={page} title="Welcome" />

export default BladeRender
