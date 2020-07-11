@extends('layouts.backend')

@section('title', trans('app.seo_setting'))

@section('content')

{{ Breadcrumbs::render('manager', [
        'name' => trans('app.seo_setting'),
        'url' => route('admin.setting.seo')
    ]) }}

<div class="cui__utils__content">
    <form action="{{ route('admin.setting.seo.save') }}" method="post" class="form-ajax">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-0 card-title font-weight-bold">@lang('app.seo_setting')</h5>
                    </div>

                    <div class="col-md-6">
                        <div class="btn-group float-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('app.save')</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        @include('backend.setting.seo.form_left')
                    </div>
                    <div class="col-md-6">
                        @include('backend.setting.seo.form_right')
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>


@endsection