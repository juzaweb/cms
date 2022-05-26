import React, { useEffect } from 'react'
import { usePage, Link } from '@inertiajs/inertia-react'
import Layout from '../Layout'

const Form = () => {
    return (
        <>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">

                    </div>
                </div>

            </div>
        </div>
        </>
    )
}

Form.layout = page => <Layout children={page} />

export default Form
