@extends('mymo_core::layouts.backend')

@section('title', trans('mymo_core::app.email_logs'))

@section('content')

    {{ Breadcrumbs::render('manager', [
            'name' => trans('mymo_core::app.email_logs'),
            'url' => route('admin.logs.email')
        ]) }}

    <div class="cui__utils__content">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-0 card-title font-weight-bold">@lang('mymo_core::app.email_logs')</h5>
                    </div>

                    <div class="col-md-6">
                        <div class="float-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-success status-button" data-status="2"><i class="fa fa-refresh"></i> @lang('mymo_core::app.resend')</button>

                                <button type="button" class="btn btn-warning status-button" data-status="3"><i class="fa fa-times-circle"></i> @lang('mymo_core::app.cancel')</button>
                            </div>

                            <div class="btn-group">

                                <button type="button" class="btn btn-danger" id="delete-item"><i class="fa fa-trash"></i> @lang('mymo_core::app.delete')</button>
                            </div>
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

                            <div class="form-group mb-2 mr-1">
                                <label for="inputStatus" class="sr-only">@lang('mymo_core::app.status')</label>
                                <select name="status" id="inputStatus" class="form-control">
                                    <option value="">--- @lang('mymo_core::app.status') ---</option>
                                    <option value="1">@lang('mymo_core::app.sended')</option>
                                    <option value="2">@lang('mymo_core::app.pending')</option>
                                    <option value="3">@lang('mymo_core::app.cancel')</option>
                                    <option value="0">@lang('mymo_core::app.error')</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search"></i> @lang('mymo_core::app.search')</button>
                        </form>
                    </div>

                </div>

                <div class="table-responsive mb-5">
                    <table class="table load-bootstrap-table">
                        <thead>
                            <tr>
                                <th data-width="3%" data-field="state" data-checkbox="true"></th>
                                <th data-field="subject">@lang('mymo_core::app.subject')</th>
                                <th data-width="20%" data-field="content">@lang('mymo_core::app.content')</th>
                                <th data-width="15%" data-field="created">@lang('mymo_core::app.created_at')</th>
                                <th data-width="15%" data-field="status" data-align="center" data-formatter="status_formatter">@lang('mymo_core::app.status')</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        function status_formatter(value, row, index) {
            if (value == 1) {
                return '<span class="text-success">@lang('mymo_core::app.sended')</span>';
            }
            
            if (value == 2) {
                return '<span class="text-success">@lang('mymo_core::app.pending')</span>';
            }

            if (value == 3) {
                return '<span class="text-success">@lang('mymo_core::app.cancel')</span>';
            }
            
            return '<span class="text-danger">@lang('mymo_core::app.error')</span>';
        }

        var table = new LoadBootstrapTable({
            url: '{{ route('admin.logs.email.getdata') }}',
            remove_url: '{{ route('admin.logs.email.remove') }}',
            status_url: '{{ route('admin.logs.email.status') }}',
        });
    </script>
@endsection