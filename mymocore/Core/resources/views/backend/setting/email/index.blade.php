@extends('mymo_core::layouts.backend')

@section('title', $title)

@section('content')

{{ Breadcrumbs::render('manager', [
        'name' => trans('mymo_core::app.email_setting'),
        'url' => route('admin.setting.email')
    ]) }}

<div class="cui__utils__content">

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 card-title font-weight-bold">{{ $title }}</h5>
        </div>

        <div class="card-body">
            <p>In order for outgoing emails (password reset, account validation, notifications etc.) to be sent out properly, you will need to configure your email provider</p>
            <p>Configuration mail in your file <b>/path/to/source/.env</b></p>
            <p>Then you can test sending mail in the field below</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-0 card-title font-weight-bold">@lang('mymo_core::app.test_configuration')</h5>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form method="post" action="{{ route('admin.setting.email.test') }}" class="form-ajax">
                <div class="form-group">
                    <label class="col-form-label" for="email">@lang('mymo_core::app.email')</label>

                    <input type="text" name="email" class="form-control" id="email" autocomplete="off">
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> @lang('mymo_core::app.send')</button>
            </form>
        </div>
    </div>
</div>
@endsection
