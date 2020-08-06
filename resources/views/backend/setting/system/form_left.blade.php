<h5>@lang('app.site_info')</h5>
<div class="form-group">
    <label class="col-form-label" for="title">@lang('app.home_title')</label>

    <input type="text" name="title" class="form-control" id="title" value="{{ get_config('title') }}" autocomplete="off" required>
</div>

<div class="form-group">
    <label class="col-form-label" for="keywords">@lang('app.keywords')</label>

    <input type="text" name="keywords" id="keywords" class="form-control" value="{{ get_config('keywords') }}" autocomplete="off">
    <em class="description">@lang('app.use_comma_to_separate_keyword')</em>
</div>

<div class="form-group">
    <label class="col-form-label" for="description">@lang('app.home_description')</label>
    <textarea class="form-control" name="description" id="description" rows="5">{{ get_config('description') }}</textarea>
</div>

<div class="form-group">
    <label class="col-form-label" for="logo">@lang('app.logo') <span class="float-right"><a href="javascript:void(0)" data-input="logo" data-preview="preview-logo" class="lfm"><i class="fa fa-edit"></i> @lang('app.change_image')</a></span></label>
    <div id="preview-logo">
        <img src="{{ image_url(get_config('logo')) }}" alt="" class="w-25">
    </div>
    <input id="logo" class="form-control" type="hidden" name="logo" value="{{ get_config('logo') }}">
</div>

<div class="form-group">
    <label class="col-form-label" for="icon">@lang('app.icon') <span class="float-right"><a href="javascript:void(0)" data-input="icon" data-preview="preview-icon" class="lfm"><i class="fa fa-edit"></i> @lang('app.change_image')</a></span></label>
    <div id="preview-icon">
        <img src="{{ image_url(get_config('icon')) }}" alt="" class="w-25">
    </div>
    <input id="icon" class="form-control" type="hidden" name="icon" value="{{ get_config('icon') }}">
</div>

<div class="form-group">
    <label class="col-form-label" for="banner">@lang('app.banner') <span class="float-right"><a href="javascript:void(0)" data-input="banner" data-preview="preview-banner" class="lfm"><i class="fa fa-edit"></i> @lang('app.change_image')</a></span></label>
    <div id="preview-banner">
        <img src="{{ image_url(get_config('banner')) }}" alt="" class="w-25">
    </div>
    <input id="banner" class="form-control" type="hidden" name="banner" value="{{ get_config('banner') }}">
</div>

@php
    $google_recaptcha = get_config('google_recaptcha');
@endphp
<h5>@lang('app.google_recaptcha')</h5>
<div class="form-group">
    <label class="col-form-label" for="google_recaptcha">@lang('app.google_recaptcha')</label>
    <select name="google_recaptcha" id="google_recaptcha" class="form-control">
        <option value="1" @if($google_recaptcha == 1) selected @endif>@lang('app.enabled')</option>
        <option value="0" @if($google_recaptcha == 0) selected @endif>@lang('app.disabled')</option>
    </select>
</div>

<div class="form-group">
    <label class="col-form-label" for="google_recaptcha_key">@lang('app.google_recaptcha_key')</label>

    <input type="text" name="google_recaptcha_key" class="form-control" id="google_recaptcha_key" value="{{ get_config('google_recaptcha_key') }}" autocomplete="off">
</div>

<div class="form-group">
    <label class="col-form-label" for="google_recaptcha_secret">@lang('app.google_recaptcha_secret')</label>

    <input type="text" name="google_recaptcha_secret" class="form-control" id="google_recaptcha_secret" value="{{ get_config('google_recaptcha_secret') }}" autocomplete="off">
</div>