<div class="theme-setting theme-setting--text editor-item">
    <label class="next-label">{{ trans('app.shop_name') }}</label>
    <input name="setting[shop_name]" class="next-input" value="{{ get_config('shop_name') }}">
</div>

<div class="theme-setting theme-setting--text editor-item">
    <label class="next-label">{{ trans('app.home_page_title') }}</label>
    <input name="setting[shop_title]" class="next-input" value="{{ get_config('shop_title') }}">
</div>

<div class="theme-setting theme-setting--text editor-item">
    <label class="next-label">{{ trans('app.home_page_description') }}</label>
    <textarea name="setting[shop_description]" class="next-input">{{ get_config('shop_description') }}</textarea>
</div>

<div class="theme-setting theme-setting--text editor-item">
<label class="next-label" for="input-logo">{{ trans('app.logo') }}</label>
<div class="review">
    <img src="{{ image_url(get_config('shop_logo')) }}" alt="" id="review-logo">
</div>

<p><a href="javascript:void(0)" class="load-media" data-input="#input-logo" data-review="#review-logo"><i class="fa fa-edit"></i> {{ trans('app.change') }}</a></p>
<input type="hidden" name="setting[shop_logo]" id="input-logo" value="{{ get_config('shop_logo') }}">
</div>

<div class="theme-setting theme-setting--text editor-item">
    <label class="next-label" for="input-icon">{{ trans('app.icon') }}</label>
    <div class="review">
        <img src="{{ image_url(get_config('shop_icon')) }}" alt="" id="review-icon">
    </div>

    <p><a href="javascript:void(0)" class="load-media" data-input="#input-icon" data-review="#review-icon"><i class="fa fa-edit"></i> {{ trans('app.change') }}</a></p>
    <input type="hidden" name="setting[shop_icon]" id="input-icon" value="{{ get_config('shop_icon') }}">
</div>