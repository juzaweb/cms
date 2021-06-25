@extends('mymo::layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-6"></div>

        <div class="col-md-6">
            {{--<div class="btn-group float-right">
                <a href="{{ route('admin.plugins.install') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> @lang('mymo::app.add-new-plugin')</a>
            </div>--}}
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-3">
            <form method="post" class="form-inline">
                @csrf
                <select name="bulk_actions" class="form-control w-60 mb-2 mr-1">
                    <option value="">@lang('mymo::app.bulk_actions')</option>
                    <option value="delete">@lang('mymo::app.delete')</option>
                    <option value="activate">@lang('mymo::app.activate')</option>
                    <option value="deactivate">@lang('mymo::app.deactivate')</option>
                </select>

                <button type="submit" class="btn btn-primary mb-2" id="apply-action">@lang('mymo::app.apply')</button>
            </form>
        </div>

        <div class="col-md-9">
            <form method="get" class="form-inline" id="form-search">
                <div class="form-group mb-2 mr-1">
                    <label for="search" class="sr-only">@lang('mymo::app.search')</label>
                    <input name="search" type="text" id="search" class="form-control" placeholder="@lang('mymo::app.search')" autocomplete="off">
                </div>

                <div class="form-group mb-2 mr-1">
                    <label for="status" class="sr-only">@lang('mymo::app.status')</label>
                    <select name="status" id="status" class="form-control select2-default">
                        <option value="">@lang('mymo::app.all_status')</option>
                        <option value="1">@lang('mymo::app.enabled')</option>
                        <option value="0">@lang('mymo::app.disabled')</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mb-2">@lang('mymo::app.search')</button>
            </form>
        </div>
    </div>

    <div class="table-responsive mb-5">
        <table class="table mymo-table">
            <thead>
                <tr>
                    <th data-width="3%" data-field="state" data-checkbox="true"></th>
                    <th data-field="name" data-formatter="nameFormatter">@lang('mymo::app.name')</th>
                    <th data-field="description" data-width="35%">@lang('mymo::app.description')</th>
                    <th data-width="15%" data-field="status" data-formatter="statusFormatter">@lang('mymo::app.status')</th>
                </tr>
            </thead>
        </table>
    </div>

    <script type="text/javascript">
        function nameFormatter(value, row, index) {
            return value;
        }
        
        function statusFormatter(value, row, index) {
            switch (value) {
                case 'inactive':
                    return `<span class='text-disable'>${mymo.lang.inactive}</span>`;
            }

            return `<span class='text-success'>${mymo.lang.active}</span>`;
        }

        var table = new MymoTable({
            url: '{{ route('admin.module.get-data') }}',
            action_url: '{{ route('admin.module.bulk-actions') }}',
        });
    </script>
@endsection