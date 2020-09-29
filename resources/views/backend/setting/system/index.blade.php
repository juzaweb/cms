@extends('layouts.backend')

@section('title', $title)

@section('content')

{{ Breadcrumbs::render('manager', [
        'name' => trans('app.system_setting'),
        'url' => route('admin.setting')
    ]) }}

<div class="cui__utils__content">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <ul class="list-group" id="setting-menu">
                        <a href="#" class="list-group-item active" data-form="general">@lang('app.site_info')</a>
                        <a href="#" class="list-group-item" data-form="recaptcha">@lang('app.google_recaptcha')</a>

                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-9">

            <div class="card">

                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-0 card-title font-weight-bold" id="setting-title"></h5>
                        </div>
                    </div>
                </div>

                <div class="card-body" id="setting-form">

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
