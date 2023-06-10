@extends('cms::layouts.backend')

@section('content')

    <div class="row">
        <div class="col-md-3">
            <div class="card border-0 bg-gray-2">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center">
                        <i class="fa fa-list font-size-50 mr-3"></i>
                        <div>
                            <div class="font-size-21 font-weight-bold">{{ trans('cms::app.posts') }}</div>
                            <div class="font-size-15">{{ trans('cms::app.total') }}: {{ number_format($posts) }}</div>
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
                            <div class="font-size-21 font-weight-bold">{{ trans('cms::app.pages') }}</div>
                            <div class="font-size-15">{{ trans('cms::app.total') }}: {{ number_format($pages) }}</div>
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
                            <div class="font-size-15">{{ trans('cms::app.total') }}/Free: {{ $storage }}/{{ $diskFree }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @do_action('backend.dashboard.statis')

    <div class="row">
        <div class="col-md-12">
            <canvas id="curve_chart" style="width: 100%; height: 300px"></canvas>
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
    </div>

    @do_action('backend.dashboard.view')

    <script type="text/javascript">
        setTimeout(function () {
            const ctx = document.getElementById('curve_chart');
            let jsonData = $.ajax({
                url: "{{ route('admin.dashboard.views_chart') }}",
                dataType: "json",
                async: false
            }).responseText;

            jsonData = JSON.parse(jsonData);
            let labels = [];
            let views = [];
            let users = [];

            $.each(jsonData, function (index, item) {
                labels.push(item[0]);
                views.push(item[1]);
                users.push(item[2]);
            });

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Page Views',
                            data: views,
                            borderWidth: 1
                        },
                        {
                            label: 'New Users',
                            data: users,
                            borderWidth: 1
                        }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }, 200);
    </script>

    <script type="text/javascript">
        function index_formatter(value, row, index) {
            return (index + 1);
        }

        function subject_formatter(value, row, index) {
            return '<a href="'+ row.url +'">'+ value +'</a>';
        }

        const table1 = new JuzawebTable({
            table: '#users-table',
            page_size: 5,
            url: '{{ route('admin.dashboard.users') }}',
        });

        const table2 = new JuzawebTable({
            table: '#posts-top-views',
            page_size: 5,
            url: '{{ route('admin.dashboard.top_views') }}',
        });
    </script>
@endsection
