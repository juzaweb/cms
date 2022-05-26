import React, {useEffect, useState} from 'react'
import Layout from '../Layout'

const Dashboard = () => {
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
        <div className="col-md-3">
            <div className="card border-0 bg-gray-2">
                <div className="card-body">
                    <div className="d-flex flex-wrap align-items-center">
                        <i className="fa fa-list font-size-50 mr-3"></i>
                        <div>
                            <div className="font-size-21 font-weight-bold">{juzaweb.lang.posts}</div>
                            <div className="font-size-15">total: {analytics.posts}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div className="col-md-3">
            <div className="card border-0 bg-info text-white">
                <div className="card-body">
                    <div className="d-flex flex-wrap align-items-center">
                        <i className="fa fa-list font-size-50 mr-3"></i>
                        <div>
                            <div className="font-size-21 font-weight-bold">{juzaweb.lang.pages}</div>
                            <div className="font-size-15">total: {analytics.pages}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div className="col-lg-3">
            <div className="card border-0 bg-success text-white">
                <div className="card-body">
                    <div className="d-flex flex-wrap align-items-center">
                        <i className="fa fa-users font-size-50 mr-3"></i>
                        <div>
                            <div className="font-size-21 font-weight-bold">{juzaweb.lang.users}</div>
                            <div className="font-size-15">total: {analytics.users}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div className="col-lg-3">
            <div className="card border-0 bg-primary text-white">
                <div className="card-body">
                    <div className="d-flex flex-wrap align-items-center">
                        <i className="fa fa-hdd-o font-size-50 mr-3"></i>
                        <div>
                            <div className="font-size-21 font-weight-bold">{juzaweb.lang.storage}</div>
                            <div className="font-size-15">total: {analytics.storage}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {/* <div className="row">
        <div className="col-md-12">
            <div id="curve_chart" style={'width': "100%", 'height': "300px"} ></div>
        </div>
    </div> */}

    {/* <div className="row mt-3">
        <div className="col-md-6">
            <div className="card">
                <div className="card-header">
                    <h5>new_users</h5>
                </div>

                <div className="card-body">
                    <table className="table" id="users-table">
                        <thead>
                            <tr>
                                <th data-formatter="index_formatter" data-width="5%">#</th>
                                <th data-field="name">{{ trans('cms::app.name') }}</th>
                                <th data-field="created" data-width="30%" data-align="center">{{ trans('cms::app.created_at') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <div className="col-md-6">
            <div className="card">
                <div className="card-header">
                    <h5>{{ trans('cms::app.top_views') }}</h5>
                </div>

                <div className="card-body">
                    <table className="table" id="posts-top-views">
                        <thead>
                            <tr>
                                <th data-formatter="index_formatter" data-width="5%">#</th>
                                <th data-field="title">{{ trans('cms::app.title') }}</th>
                                <th data-field="views" data-width="10%">{{ trans('cms::app.views') }}</th>
                                <th data-field="created" data-width="30%" data-align="center">{{ trans('cms::app.created_at') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div> */}
    </>
  )
}

Dashboard.layout = page => <Layout children={page} title="Welcome" />

export default Dashboard
