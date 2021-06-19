@extends('mymo_core::layouts.backend')

@section('title', trans('mymo_core::app.video_qualities'))

@section('content')

{{ Breadcrumbs::render('manager', [
        'name' => trans('mymo_core::app.video_qualities'),
        'url' => route('admin.video_qualities')
    ]) }}

<div class="cui__utils__content">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-0 card-title font-weight-bold">@lang('mymo_core::app.video_qualities')</h5>
                </div>

                <div class="col-md-6">
                    <div class="btn-group float-right">
                        <a href="{{ route('admin.video_qualities.create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> @lang('mymo_core::app.add_new')</a>
                        <button type="button" class="btn btn-danger" id="delete-item"><i class="fa fa-trash"></i> @lang('mymo_core::app.delete')</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-12">
                    <form method="get" class="form-inline" id="form-search">

                        <div class="form-group mb-2 mr-1">
                            <label for="inputName" class="sr-only">@lang('mymo_core::app.search')</label>
                            <input name="search" type="text" id="inputName" class="form-control" placeholder="@lang('mymo_core::app.search')" autocomplete="off">
                        </div>

                        <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search"></i> @lang('mymo_core::app.search')</button>
                    </form>
                </div>

            </div>

            <div class="table-responsive mb-5">
                <table class="table mymo-table">
                    <thead>
                        <tr>
                            <th data-width="3%" data-field="state" data-checkbox="true"></th>
                            <th data-field="name" data-formatter="name_formatter">@lang('mymo_core::app.name')</th>
                            <th data-width="10%" data-field="default" data-formatter="default_formatter" data-align="center">@lang('mymo_core::app.default')</th>
                            <th data-width="15%" data-field="created">@lang('mymo_core::app.created_at')</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

    <script type="text/javascript">
        function name_formatter(value, row, index) {
            return '<a href="'+ row.edit_url +'">'+ value +'</a>';
        }

        function default_formatter(value, row, index) {
            if (value == 1) {
                return '<span class="text-success">@lang('mymo_core::app.yes')</span>';
            }
            return '<span class="text-danger">@lang('mymo_core::app.no')</span>';
        }

        var table = new MymoTable({
            url: '{{ route('admin.video_qualities.getdata') }}',
            remove_url: '{{ route('admin.video_qualities.remove') }}',
        });
    </script>
@endsection