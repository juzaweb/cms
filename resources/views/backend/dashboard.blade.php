@extends('layouts.backend')

@section('title', trans('app.dashboard'))

@section('content')
    <div class="cui__utils__content">
        <div class="row">
            <div class="col-lg-12">
                <div class="cui__utils__heading">
                    <strong class="text-uppercase font-size-16">Statistics</strong>
                </div>
                <div class="row">
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body position-relative overflow-hidden">
                                <div class="font-size-36 font-weight-bold text-dark mb-n2">{{ $count_movie }}</div>
                                <div class="text-uppercase">@lang('app.movies')</div>
                                <div class="kit__c11__chartContainer">
                                    <div class="kit__c11__chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body position-relative overflow-hidden">
                                <div class="font-size-36 font-weight-bold text-dark mb-n2">{{ $count_tvserie }}</div>
                                <div class="text-uppercase">@lang('app.tv_series')</div>
                                <div class="kit__c11-1__chartContainer">
                                    <div class="kit__c11-1__chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body position-relative overflow-hidden">
                                <div class="font-size-36 font-weight-bold text-dark mb-n2">{{ $count_user }}</div>
                                <div class="text-uppercase">@lang('app.users')</div>
                                <div class="kit__c11-2__chartContainer">
                                    <div class="kit__c11-2__chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>@lang('app.new')</h5>
                    </div>

                    <div class="card-body">
                        <table class="table" id="users-table">
                            <thead>
                                <tr>
                                    <th data-formatter="index_formatter" data-width="5%">#</th>
                                    <th data-field="name">@lang('app.name')</th>
                                    <th data-field="email" data-width="20%">@lang('app.email')</th>
                                    <th data-formatter="created" data-width="20%">@lang('app.created_at')</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>@lang('app.new_notifications')</h5>
                    </div>

                    <div class="card-body">
                        <table class="table" id="users-notification">
                            <thead>
                                <tr>
                                    <th data-formatter="index_formatter" data-width="5%">#</th>
                                    <th data-field="subject" data-formatter="subject_formatter">@lang('app.subject')</th>
                                    <th data-formatter="created" data-width="20%">@lang('app.created_at')</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        function index_formatter(value, row, index) {
            return (index + 1);
        }

        function subject_formatter(value, row, index) {
            return '<a href="'+ row.url +'">'+ value +'</a>';
        }

        var table1 = new LoadBootstrapTable({
            table: '#users-table',
            page_size: 10,
            url: '{{ route('admin.dashboard.users') }}',
        });

        var table2 = new LoadBootstrapTable({
            table: '#users-notification',
            page_size: 10,
            url: '{{ route('admin.dashboard.notifications') }}',
        });
    </script>
@endsection