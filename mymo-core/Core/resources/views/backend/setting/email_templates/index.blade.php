@extends('mymo_core::layouts.backend')

@section('title', trans('mymo_core::app.email_templates'))

@section('content')

{{ Breadcrumbs::render('manager', [
        'name' => trans('mymo_core::app.email_templates'),
        'url' => route('admin.setting.email_templates')
    ]) }}

<div class="cui__utils__content">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-0 card-title font-weight-bold">@lang('mymo_core::app.email_templates')</h5>
                </div>

                <div class="col-md-6">
                    <div class="btn-group float-right">
                        <a href="{{ route('admin.setting.email_templates.edit_layout') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> @lang('mymo_core::app.edit_layout')</a>
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
                            <th data-width="10%" data-field="code">@lang('mymo_core::app.code')</th>
                            <th data-field="subject" data-formatter="subject_formatter">@lang('mymo_core::app.subject')</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

    <script type="text/javascript">

        function subject_formatter(value, row, index) {
            return '<a href="'+ row.edit_url +'">'+ value +'</a>';
        }

        var table = new MymoTable({
            url: '{{ route('admin.setting.email_templates.getdata') }}',
        });
    </script>
@endsection