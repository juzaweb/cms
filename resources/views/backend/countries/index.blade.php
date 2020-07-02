@extends('layouts.backend')

@section('title', trans('app.countries'))

@section('content')
    {{ Breadcrumbs::render('manager', [
        'name' => trans('app.countries'),
        'url' => route('admin.countries')
        ]) }}

    <div class="cui__utils__content">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-0 card-title font-weight-bold">@lang('app.countries')</h5>
                    </div>

                    <div class="col-md-6">
                        <div class="btn-group float-right">
                            <a href="{{ route('admin.countries.create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> @lang('app.add_new')</a>
                            <button type="button" class="btn btn-danger" wire:click="delete"><i class="fa fa-trash"></i> @lang('app.delete')</button>
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
                                <input name="query" type="text" id="inputName" class="form-control" placeholder="@lang('app.search')" wire:model="search" autocomplete="off">
                            </div>

                            <div class="form-group mb-2 mr-1">
                                <label for="inputStatus" class="sr-only">@lang('app.status')</label>
                                <select name="status" id="inputStatus" class="form-control" wire:model="status">
                                    <option value="1">@lang('app.enabled')</option>
                                    <option value="0">@lang('app.disabled')</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search"></i> @lang('app.search')</button>
                        </form>
                    </div>

                </div>

                <div class="table-responsive mb-5">
                    <table class="table">
                        <thead>
                            <tr>
                                <th data-width="3%" data-field="state" data-checkbox="true"></th>
                                <th data-width="10%" data-field="thumbnail" data-formatter="thumbnail_formatter">@lang('app.thumbnail')</th>
                                <th data-field="name" data-formatter="name_formatter">@lang('app.name')</th>
                                <th data-width="20%" data-field="description">@lang('app.description')</th>
                                <th data-width="15%" data-field="created">@lang('app.created_at')</th>
                                <th data-width="15%" data-field="status" data-formatter="status_formatter">@lang('app.status')</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
