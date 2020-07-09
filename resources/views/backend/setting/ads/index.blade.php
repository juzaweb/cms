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
                    <h5 class="mb-0 card-title font-weight-bold">@lang('app.banner_ads')</h5>
                </div>

                <div class="col-md-6">
                    <div class="btn-group float-right">
                        <a href="{{ route('admin.setting.ads.create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> @lang('app.add_new')</a>
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
                                <option value="1">@lang('app.enabled')</option>
                                <option value="0">@lang('app.disabled')</option>
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
                            <th  data-field="state" data-width="3%" data-checkbox="true"></th>
                            <th data-field="key" data-width="10%">@lang('app.code')</th>
                            <th data-field="name" data-formatter="name_formatter">@lang('app.name')</th>
                            <th data-field="status" data-width="15%" data-align="center" data-formatter="status_formatter">@lang('app.status')</th>
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
                return '<span class="text-success">@lang('app.enabled')</span>';
            }
            return '<span class="text-danger">@lang('app.disabled')</span>';
        }

        var table = new LoadBootstrapTable({
            url: '{{ route('admin.setting.ads.getdata') }}',
        });
    </script>
@endsection