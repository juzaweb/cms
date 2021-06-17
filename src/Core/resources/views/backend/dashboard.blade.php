@extends('mymo_core::layouts.backend')

@section('content')

    @do_action('backend.dashboard.view')

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
                    <h5>@lang('mymo_core::app.news')</h5>
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

    <script type="text/javascript">

        function index_formatter(value, row, index) {
            return (index + 1);
        }

        function subject_formatter(value, row, index) {
            return '<a href="'+ row.url +'" data-turbolinks="false">'+ value +'</a>';
        }

        var table1 = new MymoTable({
            table: '#users-table',
            page_size: 5,
            url: '{{ route('admin.dashboard.users') }}',
        });

        var table2 = new MymoTable({
            table: '#users-notification',
            page_size: 5,
            url: '{{ route('admin.dashboard.notifications') }}',
        });
    </script>
@endsection