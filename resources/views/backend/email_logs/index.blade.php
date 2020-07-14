@extends('layouts.backend')

@section('title', trans('app.email_logs'))

@section('content')

    {{ Breadcrumbs::render('manager', [
            'name' => trans('app.email_logs'),
            'url' => route('admin.email_logs')
        ]) }}

    <div class="cui__utils__content">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-0 card-title font-weight-bold">@lang('app.email_logs')</h5>
                    </div>

                    <div class="col-md-6">
                        <div class="float-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-success status-button" data-status="2"><i class="fa fa-refresh"></i> @lang('app.resend')</button>

                                <button type="button" class="btn btn-warning status-button" data-status="3"><i class="fa fa-times-circle"></i> @lang('app.cancel')</button>
                            </div>

                            <div class="btn-group">
                                <a href="{{ route('admin.email_logs.create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> @lang('app.add_new')</a>
                                <button type="button" class="btn btn-danger" id="delete-item"><i class="fa fa-trash"></i> @lang('app.delete')</button>
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
                                <label for="inputName" class="sr-only">@lang('app.search')</label>
                                <input name="search" type="text" id="inputName" class="form-control" placeholder="@lang('app.search')" autocomplete="off">
                            </div>

                            <div class="form-group mb-2 mr-1">
                                <label for="inputStatus" class="sr-only">@lang('app.status')</label>
                                <select name="status" id="inputStatus" class="form-control">
                                    <option value="">--- @lang('app.status') ---</option>
                                    <option value="1">@lang('app.sended')</option>
                                    <option value="2">@lang('app.pending')</option>
                                    <option value="3">@lang('app.cancel')</option>
                                    <option value="0">@lang('app.error')</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search"></i> @lang('app.search')</button>
                        </form>
                    </div>

                </div>

                <div class="table-responsive mb-5">
                    <table class="table load-bootstrap-table">
                        <thead>
                            <tr>
                                <th data-width="3%" data-field="state" data-checkbox="true"></th>
                                <th data-field="subject">@lang('app.subject')</th>
                                <th data-width="20%" data-field="content">@lang('app.content')</th>
                                <th data-width="15%" data-field="created">@lang('app.created_at')</th>
                                <th data-width="15%" data-field="status" data-align="center" data-formatter="status_formatter">@lang('app.status')</th>
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
                return '<span class="text-success">@lang('app.sended')</span>';
            }
            
            if (value == 2) {
                return '<span class="text-success">@lang('app.pending')</span>';
            }

            if (value == 3) {
                return '<span class="text-success">@lang('app.cancel')</span>';
            }
            
            return '<span class="text-danger">@lang('app.error')</span>';
        }

        var table = new LoadBootstrapTable({
            url: '{{ route('admin.email_logs.getdata') }}',
            remove_url: '{{ route('admin.email_logs.remove') }}',
        });
    </script>
@endsection