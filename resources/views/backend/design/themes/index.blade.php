@extends('layouts.backend')

@section('title', trans('app.themes'))

@section('content')
    {{ Breadcrumbs::render('manager', [
            'name' => trans('app.themes'),
            'url' => route('admin.design.themes')
        ]) }}

    <div class="cui__utils__content">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4>Mymo</h4>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                @lang('app.actived')
                            </div>

                            <div class="col-md-6 text-right">
                                <a href="{{ route('admin.design.editor') }}"><i class="fa fa-edit"></i> @lang('app.editor')</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection