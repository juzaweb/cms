import React, { useEffect, useState } from 'react'
import { usePage, Link } from '@inertiajs/inertia-react'
import Layout from '../../Layout'

const Form = () => {

    const [ fields, setFields ] = useState([]);

    useEffect(() => {
        axios.get('/admin-cp/users/1/edit?g=json', {
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(res => {
            setFields(res.data)
        });
    }, []);

    return (
        <>
        <div className="row">
            <div className="col-md-8">
                <div className="card">
                    <div className="card-body">
                        {
                            fields.map((item, index) => {
                                return (() => {
                                    switch (item.type) {
                                        case 'text':
                                            return (
                                                <div className='form-group'>
                                                    <label>{item.label}</label>
                                                    <input
                                                        type="text"
                                                        name={item.name}
                                                        className='form-control'
                                                        value={item.value}
                                                    />
                                                </div>
                                            )
                                       case 'textarea': /*Case 1 */
                                       return (
                                            <textarea className='form-control'>{item.value}</textarea>
                                        )
                                       case 'editor':/*Case 2 */
                                       return (
                                        <div>Case 2</div>
                                        )
                                    }
                                 })()
                            })
                        }
                    </div>
                </div>
            </div>

            <div className="col-md-4">
                <div className="card">
                    <div className="card-body">

                    </div>
                </div>
            </div>
        </div>
        </>
    )
}

Form.layout = page => <Layout children={page} />

export default Form
