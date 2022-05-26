import React, {useEffect, useState} from 'react'
import Layout from '../Layout'

const Update = () => {
    const [analytics, setAnalytics] = useState({
        posts: 0,
        pages: 0,
        users: 0,
        storage: 0,
    });

    useEffect(() => {
        axios.get('/admin-cp/analytics')
        .then(res => {
            setAnalytics(res.data)
        });
    }, []);

  return (
    <>
    <div className="row">
        <div className="col-md-12">
            <div className="alert alert-success">
                <p>You are using Juzaweb CMS Version: </p>
                <p>View CMS <a href="https://github.com/juzaweb/juzacms/releases" target="_blank">change logs here</a></p>
            </div>

            <div id="update-form">
                <img src="{{ asset('themes/default/assets/images/loader.gif') }}" alt="" />
            </div>
        </div>
    </div>
    </>
  )
}

Update.layout = page => <Layout children={page} />

export default Update
