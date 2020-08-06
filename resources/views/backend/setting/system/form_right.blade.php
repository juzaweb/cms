<h5>@lang('app.register')</h5>
@php
    $registration = get_config('user_registration');
    $verification = get_config('user_verification');
    $player_watermark = get_config('player_watermark');
    $video_convert = get_config('video_convert');
    $hls_video = get_config('hls_video');
    $convert_quality = get_config('video_convert_quality');
    $convert_quality = explode(',', $convert_quality);

    $qualities = [
        '240p',
        '360p',
        '480p',
        '720p',
        '1080p',
        '2048p',
        '4096p',
    ];
@endphp

<div class="form-group">
    <label class="col-form-label" for="user_registration">@lang('app.user_registration')</label>
    <select name="user_registration" id="user_registration" class="form-control">
        <option value="1" @if($registration == 1) selected @endif>@lang('app.enabled')</option>
        <option value="0" @if($registration == 0) selected @endif>@lang('app.disabled')</option>
    </select>
</div>

<div class="form-group">
    <label class="col-form-label" for="user_verification">@lang('app.user_e_mail_verification')</label>
    <select name="user_verification" id="user_verification" class="form-control">
        <option value="1" @if($verification == 1) selected @endif>@lang('app.enabled')</option>
        <option value="0" @if($verification == 0) selected @endif>@lang('app.disabled')</option>
    </select>
</div>

<h5>@lang('app.player_setting')</h5>

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

<h5>@lang('app.video_convert')</h5>
<div class="form-group">
    <label class="col-form-label" for="video_convert">@lang('app.video_convert')</label>
    <select name="video_convert" id="video_convert" class="form-control">
        <option value="1" @if($video_convert == 1) selected @endif>@lang('app.enabled')</option>
        <option value="0" @if($video_convert == 0) selected @endif>@lang('app.disabled')</option>
    </select>
</div>

<div class="form-group">
    <label class="col-form-label" for="hls_video">@lang('app.hls_video')</label>
    <select name="hls_video" id="hls_video" class="form-control">
        <option value="1" @if($hls_video == 1) selected @endif>@lang('app.enabled')</option>
        <option value="0" @if($hls_video == 0) selected @endif>@lang('app.disabled')</option>
    </select>
    <em class="description">@lang('app.hls_video_description')</em>
</div>

<div class="form-group">
    <label class="col-form-label" for="video_convert_quality">@lang('app.video_convert_quality')</label>
    <select name="video_convert_quality[]" id="video_convert_quality" class="form-control select2" multiple>
        @foreach($qualities as $quality)
        <option value="{{ $quality }}" @if(in_array($quality, $convert_quality)) selected @endif>{{ $quality }}</option>
        @endforeach
    </select>
</div>

<h5>@lang('app.tmdb')</h5>
<div class="form-group">
    <label class="col-form-label" for="tmdb_api_key">@lang('app.tmdb_api_key')</label>

    <input type="text" name="tmdb_api_key" class="form-control" id="tmdb_api_key" value="{{ get_config('tmdb_api_key') }}" autocomplete="off">
</div>