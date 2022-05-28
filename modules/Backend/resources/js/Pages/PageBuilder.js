import React, {useEffect, useState} from 'react'
import {usePage, Link} from '@inertiajs/inertia-react'
import Layout from '@/layouts/Backend'
import { JW_Field } from '@/components/atoms/Field'

const PageBuilder = () => {
    const {fields} = usePage().props;

    return (
        <JW_Field fields={fields}></JW_Field>
    )
}

PageBuilder.layout = page => <Layout children={page}/>

export default PageBuilder
