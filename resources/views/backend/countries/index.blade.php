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

                @if(session()->has('message'))
                    <div class="alert alert-success">
                        <i class="fa fa-check"></i> {{ session('message') }}
                    </div>
                @endif

                <div class="row mb-3">
                    <div class="col-md-12">
                        <form method="get" class="form-inline" wire:submit.prevent="search">

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
                                <th width="3%"><input type="checkbox" wire:click="checkAll()" value="1"></th>
                                <th>@lang('app.name')</th>
                                <th width="20%">@lang('app.description')</th>
                                <th width="15%">@lang('app.created_at')</th>
                                <th width="15%">@lang('app.status')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(!$items->isEmpty())
                            @foreach($items as $item)
                                <tr>
                                    <td><input type="checkbox" wire:click="toggleTask({{ $item->id }})" class="checked ids" value="{{ $item->id }}" {{ in_array($item->id, $ids) ? 'checked' : '' }}></td>
                                    <td><a href="{{ route('admin.genres.edit', ['id' => $item->id]) }}">{{ $item->name }}</a></td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->created_at->format('H:i m/d/Y') }}</td>
                                    <td>{{ $item->status == 1 ? trans('app.enabled') : trans('app.disabled') }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="5" align="center">@lang('app.there_is_no_data')</td></tr>
                        @endif
                        </tbody>
                    </table>

                    <div class="float-right">
                        {{ $items->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
