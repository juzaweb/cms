import React from 'react'
import Layout from '../Layout'

const Dashboard = () => {
  return (
    <>
      {/* <div class="row">
        <div class="col-md-3">
            <div class="card border-0 bg-gray-2">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center">
                        <i class="fa fa-list font-size-50 mr-3"></i>
                        <div>
                            <div class="font-size-21 font-weight-bold">Posts</div>
                            <div class="font-size-15">total: {{ number_format($posts) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 bg-info text-white">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center">
                        <i class="fa fa-list font-size-50 mr-3"></i>
                        <div>
                            <div class="font-size-21 font-weight-bold">pages</div>
                            <div class="font-size-15">total: {{ number_format($pages) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card border-0 bg-success text-white">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center">
                        <i class="fa fa-users font-size-50 mr-3"></i>
                        <div>
                            <div class="font-size-21 font-weight-bold">{{ trans('cms::app.users') }}</div>
                            <div class="font-size-15">{{ trans('cms::app.total') }}: {{ number_format($users) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card border-0 bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center">
                        <i class="fa fa-hdd-o font-size-50 mr-3"></i>
                        <div>
                            <div class="font-size-21 font-weight-bold">{{ trans('cms::app.storage') }}</div>
                            <div class="font-size-15">{{ trans('cms::app.total') }}: {{ $storage }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div id="curve_chart" style="width: 100%; height: 300px"></div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>{{ trans('cms::app.new_users') }}</h5>
                </div>

                <div class="card-body">
                    <table class="table" id="users-table">
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

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>{{ trans('cms::app.top_views') }}</h5>
                </div>

                <div class="card-body">
                    <table class="table" id="posts-top-views">
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
