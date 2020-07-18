<div class="theme-setting theme-setting--text editor-item">
    <label class="next-label">{{ trans('main.shop_name') }}</label>
    <input name="setting[shop_name]" class="next-input" value="{{ \App\Models\ShopSetting::getSetting('shop_name') }}">
</div>

<div class="theme-setting theme-setting--text editor-item">
    <label class="next-label">{{ trans('main.home_page_title') }}</label>
    <input name="setting[shop_title]" class="next-input" value="{{ \App\Models\ShopSetting::getSetting('shop_title') }}">
</div>

<div class="theme-setting theme-setting--text editor-item">
    <label class="next-label">{{ trans('main.home_page_description') }}</label>
    <textarea name="setting[shop_description]" class="next-input">{{ \App\Models\ShopSetting::getSetting('shop_description') }}</textarea>
</div>

<div class="theme-setting theme-setting--text editor-item">
<label class="next-label" for="input-logo">{{ trans('main.logo') }}</label>
<div class="review">
    <img src="{{ media_url(\App\Models\ShopSetting::getSetting('shop_logo')) }}" alt="" id="review-logo">
</div>

<p><a href="javascript:void(0)" class="load-media" data-input="#input-logo" data-review="#review-logo"><i class="fa fa-edit"></i> {{ trans('main.change') }}</a></p>
<input type="hidden" name="setting[shop_logo]" id="input-logo" value="{{ \App\Models\ShopSetting::getSetting('shop_logo') }}">
</div>

<div class="theme-setting theme-setting--text editor-item">
    <label class="next-label" for="input-icon">{{ trans('main.icon') }}</label>
    <div class="review">
        <img src="{{ media_url(\App\Models\ShopSetting::getSetting('shop_icon')) }}" alt="" id="review-icon">
    </div>

    <p><a href="javascript:void(0)" class="load-media" data-input="#input-icon" data-review="#review-icon"><i class="fa fa-edit"></i> {{ trans('main.change') }}</a></p>
    <input type="hidden" name="setting[shop_icon]" id="input-icon" value="{{ \App\Models\ShopSetting::getSetting('shop_icon') }}">
</div>