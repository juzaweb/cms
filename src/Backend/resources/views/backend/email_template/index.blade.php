@extends('mymo::layouts.backend')

@section('content')
    <div class="row mb-2">
        <div class="col-md-3">
            <form method="post" class="form-inline">
                <select name="bulk_actions" class="form-control w-60 mb-2 mr-1">
                    <option value="">@lang('mymo::app.bulk_actions')</option>
                    <option value="delete">@lang('mymo::app.delete')</option>
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

                <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search"></i> @lang('mymo::app.search')</button>
            </form>
        </div>
    </div>

    <div class="table-responsive mb-5">
        <table class="table mymo-table">
            <thead>
                <tr>
                    <th data-width="3%" data-field="state" data-checkbox="true"></th>
                    <th data-field="code" data-sortable="true" data-formatter="name_formatter">@lang('mymo::app.code')</th>
                    <th data-width="20%" data-field="subject">@lang('mymo::app.subject')</th>
                    <th data-width="15%" data-sortable="true" data-field="created_at">@lang('mymo::app.created_at')</th>
                </tr>
            </thead>
        </table>
    </div>

    <script type="text/javascript">
        function name_formatter(value, row, index) {
            return '<a href="'+ row.edit_url +'">'+ row.code +'</a>';
        }

        var table = new MymoTable({
            url: '{{ route('admin.email-template.get-data') }}',
            action_url: '{{ route('admin.email-template.bulk-actions') }}',
        });
    </script>
@endsection