@extends('layouts.backend')

@section('title', trans('app.banner_ads'))

@section('content')

{{ Breadcrumbs::render('manager', [
        'name' => trans('app.banner_ads'),
        'url' => route('admin.setting.ads')
    ]) }}

<div class="cui__utils__content">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-0 card-title font-weight-bold">@lang('mymo_core::app.banner_ads')</h5>
                </div>

                <div class="col-md-6">

                </div>
            </div>
        </div>

        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-12">
                    <form method="get" class="form-inline" id="form-search">

                        <div class="form-group mb-2 mr-1">
                            <label for="search" class="sr-only">@lang('mymo_core::app.search')</label>
                            <input name="search" type="text" id="search" class="form-control" placeholder="@lang('mymo_core::app.search')" autocomplete="off">
                        </div>

                        <div class="form-group mb-2 mr-1">
                            <label for="status" class="sr-only">@lang('mymo_core::app.status')</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1">@lang('mymo_core::app.enabled')</option>
                                <option value="0">@lang('mymo_core::app.disabled')</option>
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
                            <th  data-field="state" data-width="3%" data-checkbox="true"></th>
                            <th data-field="key" data-width="10%">@lang('mymo_core::app.code')</th>
                            <th data-field="name" data-formatter="name_formatter">@lang('mymo_core::app.name')</th>
                            <th data-field="status" data-width="15%" data-align="center" data-formatter="status_formatter">@lang('mymo_core::app.status')</th>
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
                return '<span class="text-success">@lang('mymo_core::app.enabled')</span>';
            }
            return '<span class="text-danger">@lang('mymo_core::app.disabled')</span>';
        }

        var table = new LoadBootstrapTable({
            url: '{{ route('admin.setting.ads.getdata') }}',
        });
    </script>
@endsection