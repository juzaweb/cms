<h5>@lang('app.register')</h5>
@php
    $user_registration = get_config('user_registration');
@endphp

<div class="form-group">
    <label class="col-form-label" for="user_registration">@lang('app.user_registration')</label>
    <select name="user_registration" id="user_registration" class="form-control">
        <option value="1" @if($user_registration == 1) selected @endif>@lang('app.enabled')</option>
        <option value="0" @if($user_registration == 0) selected @endif>@lang('app.disabled')</option>
    </select>
</div>

@php
    $user_verification = get_config('user_verification');
@endphp
<div class="form-group">
    <label class="col-form-label" for="user_verification">@lang('app.user_e_mail_verification')</label>
    <select name="user_verification" id="user_verification" class="form-control">
        <option value="1" @if($user_verification == 1) selected @endif>@lang('app.enabled')</option>
        <option value="0" @if($user_verification == 0) selected @endif>@lang('app.disabled')</option>
    </select>
</div>

<h5>@lang('app.player_setting')</h5>

@php
    $player_watermark = get_config('player_watermark');
@endphp

<div class="form-group">
    <label class="col-form-label" for="player_watermark">@lang('app.player_watermark')</label>
    <select name="player_watermark" id="player_watermark" class="form-control">
        <option value="1" @if($player_watermark == 1) selected @endif>@lang('app.enabled')</option>
        <option value="0" @if($player_watermark == 0) selected @endif>@lang('app.disabled')</option>
    </select>
</div>

<div class="form-group">
    <label class="col-form-label" for="logo">@lang('app.player_watermark_logo') <span class="float-right"><a href="javascript:void(0)" data-input="player_watermark_logo" data-preview="preview-watermark_logo" class="lfm"><i class="fa fa-edit"></i> @lang('app.change_image')</a></span></label>
    <div id="preview-watermark_logo" class="preview-image">
        <img src="{{ image_url(get_config('player_watermark_logo')) }}" alt="" class="w-100">
    </div>
    <input id="player_watermark_logo" class="form-control" type="hidden" name="player_watermark_logo" value="{{ get_config('player_watermark_logo') }}">
</div>