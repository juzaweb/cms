@extends('mymo_core::layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <div class="btn-group float-right">
                <a href="{{ route('admin.notification.create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> @lang('mymo_core::app.add_new')</a>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <form method="post" class="form-inline">
                @csrf
                <select name="bulk_actions" class="form-control w-60 mb-2 mr-1">
                    <option value="">@lang('mymo_core::app.bulk_actions')</option>
                    <option value="send">@lang('mymo_core::app.send')</option>
                    <option value="delete">@lang('mymo_core::app.delete')</option>
                </select>

                <button type="submit" class="btn btn-primary mb-2" id="apply-action">@lang('mymo_core::app.apply')</button>
            </form>
        </div>

        <div class="col-md-8">
            <form method="get" class="form-inline" id="form-search">
                <div class="form-group mb-2 mr-1">
                    <label for="search" class="sr-only">@lang('mymo_core::app.search')</label>
                    <input name="search" type="text" id="search" class="form-control" placeholder="@lang('mymo_core::app.search')" autocomplete="off">
                </div>

                <div class="form-group mb-2 mr-1">
                    <label for="status" class="sr-only">@lang('mymo_core::app.status')</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">--- @lang('mymo_core::app.status') ---</option>
                        <option value="1">@lang('mymo_core::app.enabled')</option>
                        <option value="0">@lang('mymo_core::app.disabled')</option>
                    </select>
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
                    <th data-field="subject" data-formatter="subject_formatter">@lang('mymo_core::app.subject')</th>
                    <th data-field="method" data-width="20%" data-formatter="via_formatter">@lang('mymo_core::app.via')</th>
                    <th data-field="created" data-width="15%">@lang('mymo_core::app.created_at')</th>
                    <th data-field="error" data-width="15%">@lang('mymo_core::app.error')</th>
                    <th data-field="status" data-width="15%" data-align="center" data-formatter="status_formatter">@lang('mymo_core::app.status')</th>
                </tr>
            </thead>
        </table>
    </div>

    <script type="text/javascript">
        function via_formatter(value, row, index) {
            if (row.method) {
                return row.method;
            }

            return "{{ trans('mymo_core::app.all') }}";
        }

        function subject_formatter(value, row, index) {
            return '<a href="'+ row.edit_url +'">'+ row.data.subject +'</a>';
        }

        function status_formatter(value, row, index) {
            let status = parseInt(value);

            switch (status) {
                case 0: return "{{ trans('mymo_core::app.error') }}";
                case 1: return "{{ trans('mymo_core::app.sended') }}";
                case 2: return "{{ trans('mymo_core::app.pending') }}";
                case 3: return "{{ trans('mymo_core::app.sending') }}";
                case 4: return "{{ trans('mymo_core::app.unsent') }}";
            }
        }

        var table = new MymoTable({
            url: '{{ route('admin.notification.get-data') }}',
            action_url: '{{ route('admin.notification.bulk-actions') }}',
        });
    </script>
@endsection