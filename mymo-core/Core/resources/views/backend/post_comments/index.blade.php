@extends('mymo_core::layouts.backend')

@section('title', trans('mymo_core::app.post_comments'))

@section('content')

{{ Breadcrumbs::render('manager', [
        'name' => trans('mymo_core::app.post_comments'),
        'url' => route('admin.post_comments')
    ]) }}

<div class="cui__utils__content">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-0 card-title font-weight-bold">@lang('mymo_core::app.post_comments')</h5>
                </div>

                <div class="col-md-6">
                    <div class="float-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-success status-button" data-status="1"><i class="fa fa-check-circle"></i> @lang('mymo_core::app.show')</button>
                            <button type="button" class="btn btn-warning status-button" data-status="0"><i class="fa fa-times-circle"></i> @lang('mymo_core::app.hidden')</button>
                        </div>

                        <div class="btn-group">
                            <button type="button" class="btn btn-success status-button" data-status="2"><i class="fa fa-check-circle"></i> @lang('mymo_core::app.approve')</button>
                            <button type="button" class="btn btn-warning status-button" data-status="3"><i class="fa fa-times-circle"></i> @lang('mymo_core::app.deny')</button>
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
                            <label for="inputApprove" class="sr-only">@lang('mymo_core::app.approve')</label>
                            <select name="approve" id="inputApprove" class="form-control">
                                <option value="">--- @lang('mymo_core::app.approve') ---</option>
                                <option value="1">@lang('mymo_core::app.approved')</option>
                                <option value="0">@lang('mymo_core::app.deny')</option>
                            </select>
                        </div>

                        <div class="form-group mb-2 mr-1">
                            <label for="inputStatus" class="sr-only">@lang('mymo_core::app.status')</label>
                            <select name="status" id="inputStatus" class="form-control">
                                <option value="">--- @lang('mymo_core::app.status') ---</option>
                                <option value="1">@lang('mymo_core::app.show')</option>
                                <option value="0">@lang('mymo_core::app.hidden')</option>
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
                            <th data-field="author">@lang('mymo_core::app.author')</th>
                            <th data-width="30%" data-field="content">@lang('mymo_core::app.content')</th>
                            <th data-width="15%" data-field="post">@lang('mymo_core::app.post')</th>
                            <th data-width="15%" data-field="created">@lang('mymo_core::app.created_at')</th>
                            <th data-width="10%" data-field="approved" data-align="center" data-formatter="approve_formatter">@lang('mymo_core::app.approve')</th>
                            <th data-width="10%" data-field="status" data-align="center" data-formatter="status_formatter">@lang('mymo_core::app.status')</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

    <script type="text/javascript">
        function thumbnail_formatter(value, row, index) {
            return '<img src="'+ row.thumb_url +'" class="w-100">';
        }

        function approve_formatter(value, row, index) {
            if (value == 1) {
                return '<span class="text-success">@lang('mymo_core::app.approved')</span>';
            }
            return '<span class="text-danger">@lang('mymo_core::app.deny')</span>';
        }

        function status_formatter(value, row, index) {
            if (value == 1) {
                return '<span class="text-success">@lang('mymo_core::app.show')</span>';
            }
            return '<span class="text-danger">@lang('mymo_core::app.hidden')</span>';
        }

        var table = new LoadBootstrapTable({
            url: '{{ route('admin.post_comments.getdata') }}',
            remove_url: '{{ route('admin.post_comments.remove') }}',
            status_url: '{{ route('admin.post_comments.publicis') }}',
        });
    </script>
@endsection