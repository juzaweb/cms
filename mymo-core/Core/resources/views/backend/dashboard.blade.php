@extends('mymo_core::layouts.backend')

@section('title', trans('app.dashboard'))

@section('content')
    <div class="cui__utils__content">
        <div class="row">
            <div class="col-lg-12">
                <div class="cui__utils__heading">
                    <strong class="text-uppercase font-size-16">@lang('mymo_core::app.statistics')</strong>
                </div>
                <div class="row">
                    {{--<div class="col-xl-3">
                        <div class="card">
                            <div class="card-body position-relative overflow-hidden">
                                <div class="font-size-36 font-weight-bold text-dark mb-n2">{{ $count_movie }}</div>
                                <div class="text-uppercase">@lang('mymo_core::app.movies')</div>

                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3">
                        <div class="card">
                            <div class="card-body position-relative overflow-hidden">
                                <div class="font-size-36 font-weight-bold text-dark mb-n2">{{ $count_tvserie }}</div>
                                <div class="text-uppercase">@lang('mymo_core::app.tv_series')</div>

                            </div>
                        </div>
                    </div>--}}

                    <div class="col-xl-3">
                        <div class="card">
                            <div class="card-body position-relative overflow-hidden">
                                <div class="font-size-36 font-weight-bold text-dark mb-n2">{{ $count_user }}</div>
                                <div class="text-uppercase">@lang('mymo_core::app.users')</div>

                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3">
                        <div class="card">
                            <div class="card-body position-relative overflow-hidden">
                                <div class="font-size-36 font-weight-bold text-dark mb-n2">{{ $count_page }}</div>
                                <div class="text-uppercase">@lang('mymo_core::app.pages')</div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div id="curve_chart" style="width: 100%; height: 400px"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>@lang('mymo_core::app.new_users')</h5>
                    </div>

                    <div class="card-body">
                        <table class="table" id="users-table">
                            <thead>
                                <tr>
                                    <th data-formatter="index_formatter" data-width="5%">#</th>
                                    <th data-field="name">@lang('mymo_core::app.name')</th>
                                    <th data-field="created" data-width="30%" data-align="center">@lang('mymo_core::app.created_at')</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>@lang('mymo_core::app.new_notifications')</h5>
                    </div>

                    <div class="card-body">
                        <table class="table" id="users-notification">
                            <thead>
                                <tr>
                                    <th data-formatter="index_formatter" data-width="5%">#</th>
                                    <th data-field="subject" data-formatter="subject_formatter">@lang('mymo_core::app.subject')</th>
                                    <th data-field="created" data-width="30%" data-align="center">@lang('mymo_core::app.created_at')</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                title: '@lang('mymo_core::app.chart_of_views_this_month')',
                curveType: 'function',
                legend: { position: 'bottom' },
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

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

        var table1 = new LoadBootstrapTable({
            table: '#users-table',
            page_size: 5,
            url: '{{ route('admin.dashboard.users') }}',
        });

        var table2 = new LoadBootstrapTable({
            table: '#users-notification',
            page_size: 5,
            url: '{{ route('admin.dashboard.notifications') }}',
        });
    </script>
@endsection