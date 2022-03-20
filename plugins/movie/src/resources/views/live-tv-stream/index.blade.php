@extends('cms::layouts.backend')

@section('title', trans('mymo::app.stream'))

@section('content')

<div class="cui__utils__content">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-0 card-title font-weight-bold">@lang('mymo::app.genres')</h5>
                </div>

                <div class="col-md-6">
                    <div class="btn-group float-right">
                        <a href="{{ route('admin.live-tv.stream.create', [$live_tv->id]) }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> @lang('mymo::app.add_new')</a>
                        <button type="button" class="btn btn-danger" id="delete-item"><i class="fa fa-trash"></i> @lang('mymo::app.delete')</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-12">
                    <form method="get" class="form-inline" id="form-search">

                        <div class="form-group mb-2 mr-1">
                            <label for="search" class="sr-only">@lang('mymo::app.search')</label>
                            <input name="search" type="text" id="search" class="form-control" placeholder="@lang('mymo::app.search')" autocomplete="off">
                        </div>

                        <div class="form-group mb-2 mr-1">
                            <label for="status" class="sr-only">@lang('mymo::app.status')</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">--- @lang('mymo::app.status') ---</option>
                                <option value="1">@lang('mymo::app.enabled')</option>
                                <option value="0">@lang('mymo::app.disabled')</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search"></i> @lang('mymo::app.search')</button>
                    </form>
                </div>

            </div>

            <div class="table-responsive mb-5">
                <table class="table mymo-table">
                    <thead>
                        <tr>
                            <th data-width="3%" data-field="state" data-checkbox="true"></th>
                            <th data-field="name" data-formatter="name_formatter">@lang('mymo::app.name')</th>
                            <th data-width="15%" data-field="created">@lang('mymo::app.created_at')</th>
                            <th data-width="15%" data-field="status" data-align="center" data-formatter="status_formatter">@lang('mymo::app.status')</th>
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

        function status_formatter(value, row, index) {
            if (value == 1) {
                return '<span class="text-success">@lang('mymo::app.enabled')</span>';
            }
            return '<span class="text-danger">@lang('mymo::app.disabled')</span>';
        }

        var table = new JuzawebTable({
            url: '{{ route('admin.live-tv.stream.getdata', [$live_tv->id]) }}',
            remove_url: '{{ route('admin.live-tv.stream.remove', [$live_tv->id]) }}',
        });
    </script>
@endsection