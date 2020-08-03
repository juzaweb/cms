@extends('layouts.backend')

@section('title', $title)

@section('content')

{{ Breadcrumbs::render('manager', [
        'name' => trans('app.email_setting'),
        'url' => route('admin.setting.email')
    ]) }}

<div class="cui__utils__content">
    <form method="post" action="{{ route('admin.setting.email.save') }}" class="form-ajax">
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

                            <input type="text" name="mail_host" class="form-control" id="mail_host" value="{{ get_config('mail_host') }}" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="mail_driver">@lang('app.mail_driver')</label>

                            @php
                            $mail_driver = get_config('mail_driver');
                            @endphp
                            <select name="mail_driver" id="mail_driver" class="form-control">
                                <option value="smtp" @if($mail_driver == 'smtp') selected @endif>smtp</option>
                                <option value="sendmail" @if($mail_driver == 'sendmail') selected @endif>sendmail</option>
                                <option value="mailgun" @if($mail_driver == 'mailgun') selected @endif>mailgun</option>
                                <option value="mandrill" @if($mail_driver == 'mandrill') selected @endif>mandrill</option>
                                <option value="ses" @if($mail_driver == 'ses') selected @endif>ses</option>
                                <option value="sparkpost" @if($mail_driver == 'sparkpost') selected @endif>sparkpost</option>
                                <option value="postmark" @if($mail_driver == 'postmark') selected @endif>postmark</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="mail_port">@lang('app.mail_port')</label>

                            <input type="text" name="mail_port" class="form-control" id="mail_port" value="{{ get_config('mail_port') }}" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="mail_username">@lang('app.mail_username')</label>

                            <input type="text" name="mail_username" class="form-control" id="mail_username" value="{{ get_config('mail_username') }}" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="mail_password">@lang('app.mail_password')</label>

                            <input type="text" name="mail_password" class="form-control" id="mail_password" value="{{ get_config('mail_password') }}" autocomplete="off">
                        </div>

                        @php
                            $mail_encryption = get_config('mail_encryption');
                        @endphp
                        <div class="form-group">
                            <label class="col-form-label" for="mail_encryption">@lang('app.mail_encryption')</label>
                            <select name="mail_encryption" id="mail_encryption" class="form-control">
                                <option value="">null</option>
                                <option value="tls" @if($mail_encryption == 'tls') selected @endif>tls</option>
                                <option value="ssl" @if($mail_encryption == 'ssl') selected @endif>ssl</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="mail_from_name">@lang('app.mail_from_name')</label>

                            <input type="text" name="mail_from_name" class="form-control" id="mail_from_name" value="{{ get_config('mail_from_name') }}" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="mail_from_address">@lang('app.mail_from_address')</label>

                            <input type="text" name="mail_from_address" class="form-control" id="mail_from_address" value="{{ get_config('mail_from_address') }}" autocomplete="off">
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
            <form method="post" action="{{ route('admin.setting.email.test') }}" class="form-ajax">
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
