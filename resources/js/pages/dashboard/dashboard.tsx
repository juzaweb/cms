import {__} from "@/helpers/functions";

export default function Dashboard({ posts, pages, users, storage, diskFree }) {
    return (
        <>
            <div className="row">
                <div className="col-md-3">
                    <div className="card border-0 bg-gray-2">
                        <div className="card-body">
                            <div className="d-flex flex-wrap align-items-center">
                                <i className="fa fa-list font-size-50 mr-3"></i>
                                <div>
                                    <div className="font-size-21 font-weight-bold">{ __('cms::app.posts') }</div>
                                    <div className="font-size-15">{ __('cms::app.total') }: { posts}</div>
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
                                    <div className="font-size-21 font-weight-bold">{ __('cms::app.pages') }</div>
                                    <div className="font-size-15">{ __('cms::app.total') }: { pages }</div>
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
                                    <div className="font-size-21 font-weight-bold">{ __('cms::app.users') }</div>
                                    <div className="font-size-15">{ __('cms::app.total') }: { users }</div>
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
                                    <div className="font-size-21 font-weight-bold">{ __('cms::app.storage') }</div>
                                    <div className="font-size-15">{ __('cms::app.total') }/Free: { storage }/{ diskFree }</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @do_action('backend.dashboard.statis')

            <div className="row">
                <div className="col-md-12">
                    <canvas id="curve_chart" style="width: 100%; height: 300px"></canvas>
                </div>
            </div>

            <div className="row mt-3">
                <div className="col-md-6">
                    <div className="card">
                        <div className="card-header">
                            <h5>{ __('cms::app.new_users') }</h5>
                        </div>

                        <div className="card-body">
                            <table className="table" id="users-table">
                                <thead>
                                <tr>
                                    <th data-formatter="index_formatter" data-width="5%">#</th>
                                    <th data-field="name">{ __('cms::app.name') }</th>
                                    <th data-field="created" data-width="30%" data-align="center">{ __('cms::app.created_at') }</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

                <div className="col-md-6">
                    <div className="card">
                        <div className="card-header">
                            <h5>{ __('cms::app.top_views') }</h5>
                        </div>

                        <div className="card-body">
                            <table className="table" id="posts-top-views">
                                <thead>
                                <tr>
                                    <th data-formatter="index_formatter" data-width="5%">#</th>
                                    <th data-field="title">{ __('cms::app.title') }</th>
                                    <th data-field="views" data-width="10%">{ __('cms::app.views') }</th>
                                    <th data-field="created" data-width="30%" data-align="center">{ __('cms::app.created_at') }</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            @do_action('backend.dashboard.view')
        </>
    );
}
