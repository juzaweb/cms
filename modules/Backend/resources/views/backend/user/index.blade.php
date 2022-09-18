@extends('cms::layouts.backend')

@section('content')

    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <div class="btn-group float-right">
                <a href="{{ route('admin.users.create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> {{ trans('cms::app.add_new') }}</a>
            </div>
        </div>
    </div>

    {{ $dataTable->render() }}

    <script type="text/javascript">
        function status_formatter(value, row, index) {
            switch (row.status) {
                case 'active':
                    return `<span class="text-success">${juzaweb.lang.active}</span>`;
                case 'unconfirmed':
                    return `<span class="text-warning">${juzaweb.lang.unconfirmed}</span>`;
                case 'banned':
                    return `<span class="text-danger">${juzaweb.lang.banned}</span>`;
            }

            return `<span class="text-danger">${juzaweb.lang.disabled}</span>`;
        }
    </script>
@endsection
