@extends('layouts.backend')

@section('title', $title)

@section('content')

{{ Breadcrumbs::render('manager', [
        'name' => trans('app.email_setting'),
        'url' => route('admin.setting.email')
    ]) }}

<div class="cui__utils__content">
    <form method="post" action="{{ route('admin.setting.comment.save') }}" class="form-ajax">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-0 card-title font-weight-bold">{{ $title }}</h5>
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
                    <div class="col-md-12">

                        <div class="form-group">
                            <label class="col-form-label" for="mail_host">@lang('app.mail_host')</label>

                            <input type="text" name="mail_host" class="form-control" id="mail_host" value="{{ \App\Models\Configs::getConfig('mail_host') }}" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="mail_driver">@lang('app.mail_driver')</label>

                            <input type="text" name="mail_driver" class="form-control" id="mail_driver" value="{{ \App\Models\Configs::getConfig('mail_driver') }}" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="mail_port">@lang('app.mail_port')</label>

                            <input type="text" name="mail_post" class="form-control" id="mail_port" value="{{ \App\Models\Configs::getConfig('mail_port') }}" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="mail_username">@lang('app.mail_username')</label>

                            <input type="text" name="mail_username" class="form-control" id="mail_username" value="{{ \App\Models\Configs::getConfig('mail_username') }}" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="mail_password">@lang('app.mail_password')</label>

                            <input type="text" name="mail_password" class="form-control" id="mail_password" value="{{ \App\Models\Configs::getConfig('mail_password') }}" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="mail_from_name">@lang('app.mail_from_name')</label>

                            <input type="text" name="mail_from_name" class="form-control" id="mail_from_name" value="{{ \App\Models\Configs::getConfig('mail_from_name') }}" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="mail_from_address">@lang('app.mail_from_address')</label>

                            <input type="text" name="mail_from_address" class="form-control" id="mail_from_address" value="{{ \App\Models\Configs::getConfig('mail_from_address') }}" autocomplete="off">
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </form>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-0 card-title font-weight-bold">@lang('app.test_configuration')</h5>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form method="post" action="" class="form-ajax">
                <div class="form-group">
                    <label class="col-form-label" for="email">@lang('app.email')</label>

                    <input type="text" name="email" class="form-control" id="email" autocomplete="off">
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> @lang('app.send')</button>
            </form>
        </div>
    </div>
</div>
@endsection
