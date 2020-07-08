@extends('layouts.backend')

@section('title', $title)

@section('content')

{{ Breadcrumbs::render('manager', [
        'name' => trans('app.system_setting'),
        'url' => route('admin.setting')
    ]) }}

<div class="cui__utils__content">
    <form method="post" action="{{ route('admin.setting.save') }}" class="form-ajax">
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
                    <div class="col-md-8">
                        <h5>@lang('app.site_info')</h5>
                        <div class="form-group">
                            <label class="col-form-label" for="title">@lang('app.name')</label>

                            <input type="text" name="title" class="form-control" id="title" value="{{ \App\Models\Configs::getConfig('title') }}" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="description">@lang('app.description')</label>
                            <textarea class="form-control" name="description" id="description" rows="5">{{ \App\Models\Configs::getConfig('description') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="logo">@lang('app.logo') <span class="float-right"><a href="javascript:void(0)" data-input="logo" data-preview="preview-logo" class="lfm"><i class="fa fa-edit"></i> @lang('app.change_image')</a></span></label>
                            <div id="preview-logo">
                                <img src="{{ image_url(\App\Models\Configs::getConfig('logo')) }}" alt="" class="w-25">
                            </div>
                            <input id="logo" class="form-control" type="hidden" name="logo" value="{{ \App\Models\Configs::getConfig('logo') }}">
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="icon">@lang('app.icon') <span class="float-right"><a href="javascript:void(0)" data-input="icon" data-preview="preview-icon" class="lfm"><i class="fa fa-edit"></i> @lang('app.change_image')</a></span></label>
                            <div id="preview-icon">
                                <img src="{{ image_url(\App\Models\Configs::getConfig('icon')) }}" alt="" class="w-25">
                            </div>
                            <input id="icon" class="form-control" type="hidden" name="icon" value="{{ \App\Models\Configs::getConfig('icon') }}">
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="banner">@lang('app.banner') <span class="float-right"><a href="javascript:void(0)" data-input="banner" data-preview="preview-banner" class="lfm"><i class="fa fa-edit"></i> @lang('app.change_image')</a></span></label>
                            <div id="preview-banner">
                                <img src="{{ image_url(\App\Models\Configs::getConfig('banner')) }}" alt="" class="w-25">
                            </div>
                            <input id="banner" class="form-control" type="hidden" name="banner" value="{{ \App\Models\Configs::getConfig('banner') }}">
                        </div>

                        <h5>@lang('app.google_recaptcha')</h5>
                        <div class="form-group">
                            <label class="col-form-label" for="google_recaptcha">@lang('app.google_recaptcha')</label>
                            <select name="google_recaptcha" id="google_recaptcha" class="form-control">
                                <option value="1">@lang('app.enabled')</option>
                                <option value="0">@lang('app.disabled')</option>
                            </select>
                            <em class="description"></em>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="google_recaptcha_key">@lang('app.google_recaptcha_key')</label>

                            <input type="text" name="google_recaptcha_key" class="form-control" id="google_recaptcha_key" value="{{ \App\Models\Configs::getConfig('google_recaptcha_key') }}" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="google_recaptcha_secret">@lang('app.google_recaptcha_secret')</label>

                            <input type="text" name="google_recaptcha_secret" class="form-control" id="google_recaptcha_secret" value="{{ \App\Models\Configs::getConfig('google_recaptcha_secret') }}" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <h5>@lang('app.register')</h5>

                        <div class="form-group">
                            <label class="col-form-label" for="user_registration">@lang('app.user_registration')</label>
                            <select name="user_registration" id="user_registration" class="form-control">
                                <option value="1">@lang('app.enabled')</option>
                                <option value="0">@lang('app.disabled')</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="user_verification">@lang('app.user_e_mail_verification')</label>
                            <select name="user_verification" id="user_verification" class="form-control">
                                <option value="1">@lang('app.enabled')</option>
                                <option value="0">@lang('app.disabled')</option>
                            </select>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </form>
</div>
@endsection
