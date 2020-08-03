@extends('layouts.backend')

@section('title', trans('app.movies'))

@section('content')

{{ Breadcrumbs::render('manager', [
        'name' => trans('app.movies'),
        'url' => route('admin.movies')
    ]) }}

<div class="cui__utils__content">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-0 card-title font-weight-bold">@lang('app.movies')</h5>
                </div>

                <div class="col-md-6">
                    <div class="float-right">
                        <div class="btn-group">
                            <a href="javascript:void(0)" class="btn btn-success" data-toggle="modal" data-target="#tmdb-modal"><i class="fa fa-plus"></i> @lang('app.add_from_tmdb')</a>
                        </div>

                        <div class="btn-group">
                            <a href="{{ route('admin.movies.create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> @lang('app.add_new')</a>
                            <button class="btn btn-danger" type="button"><i class="fa fa-trash"></i> @lang('app.delete')</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-12">
                    <form action="" method="get" class="form-inline" id="form-search">

                        <div class="form-group mb-2 mr-1">
                            <label for="inputSearch" class="sr-only">@lang('app.search')</label>
                            <input name="search" type="text" id="inputSearch" class="form-control" placeholder="@lang('app.search')" autocomplete="off">
                        </div>

                        <div class="form-group mb-2 mr-1">
                            <label for="genre" class="sr-only">@lang('app.genre')</label>
                            <select name="genre" id="genre" class="form-control load-genres" data-placeholder="--- @lang('app.genre') ---"></select>
                        </div>

                        <div class="form-group mb-2 mr-1">
                            <label for="country" class="sr-only">@lang('app.country')</label>
                            <select name="country" id="country" class="form-control load-countries" data-placeholder="--- @lang('app.country') ---"></select>
                        </div>

                        <div class="form-group mb-2 mr-1">
                            <label for="inputStatus" class="sr-only">@lang('app.status')</label>
                            <select name="status" id="inputStatus" class="form-control">
                                <option value="">--- @lang('app.status') ---</option>
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
                            <th data-width="3%" data-field="state" data-checkbox="true"></th>
                            <th data-width="10%" data-field="thumbnail" data-formatter="thumbnail_formatter">@lang('app.thumbnail')</th>
                            <th data-field="name" data-formatter="name_formatter">@lang('app.name')</th>
                            <th data-width="20%" data-field="description">@lang('app.description')</th>
                            <th data-width="15%" data-field="status" data-align="center" data-formatter="status_formatter">@lang('app.status')</th>
                            <th data-width="20%" data-field="options" data-align="center" data-formatter="options_formatter">@lang('app.options')</th>
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

    function name_formatter(value, row, index) {
        return '<a href="'+ row.edit_url +'">'+ value +'</a>';
    }

    function status_formatter(value, row, index) {
        if (value == 1) {
            return '<span class="text-success">'+ langs.enabled +'</span>';
        }
        return '<span class="text-danger">'+ langs.disabled +'</span>';
    }

    function options_formatter(value, row, index) {
        let result = '';
        result += '<a href="'+ row.preview_url +'" target="_blank" class="btn btn-success btn-sm mr-1" data-turbolinks="false"><i class="fa fa-eye"></i> '+ langs.preview +'</a>';
        result += '<a href="'+ row.upload_url +'" class="btn btn-success btn-sm"><i class="fa fa-upload"></i> '+ langs.upload +'</a>';
        return result;
    }

    var table = new LoadBootstrapTable({
        url: '{{ route('admin.movies.getdata') }}',
        remove_url: '{{ route('admin.movies.remove') }}',
    });
</script>

@include('backend.movies.form_tmdb')
@endsection
