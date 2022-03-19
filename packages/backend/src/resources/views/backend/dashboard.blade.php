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
    </div>

    @do_action('backend.dashboard.view')

    <script type="text/javascript">
        setTimeout(function () {
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);
        }, 200);

        function drawChart() {
            var jsonData = $.ajax({
                url: "{{ route('admin.dashboard.views_chart') }}",
                dataType: "json",
                async: false
            }).responseText;
            jsonData = JSON.parse(jsonData);

            var data = google.visualization.arrayToDataTable(jsonData);

            var options = {
                title: "{{ trans('cms::app.chart_post_views_this_week') }}",
                curveType: 'function',
                legend: { position: 'bottom' },
                vAxis: {
                    minValue:0,
                    viewWindow: {
                        min: 0
                    }
                }
            };

            var chart = new google.visualization.LineChart(
                document.getElementById('curve_chart')
            );

            chart.draw(data, options);
        }
    </script>

    <script type="text/javascript">
        function index_formatter(value, row, index) {
            return (index + 1);
        }

        function subject_formatter(value, row, index) {
            return '<a href="'+ row.url +'" data-turbolinks="false">'+ value +'</a>';
        }

        var table1 = new JuzawebTable({
            table: '#users-table',
            page_size: 5,
            url: '{{ route('admin.dashboard.users') }}',
        });

        var table2 = new JuzawebTable({
            table: '#posts-top-views',
            page_size: 5,
            url: '{{ route('admin.dashboard.top_views') }}',
        });
    </script>
@endsection