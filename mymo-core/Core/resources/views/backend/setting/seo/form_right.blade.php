<div class="card">
    <div class="card-header bg-primary">
        <h5 class="mb-0 card-title font-weight-bold text-white">@lang('mymo_core::app.home_page_seo')</h5>
    </div>

    <div class="card-body">

        <div class="form-group">
            <label class="col-form-label" for="title">@lang('mymo_core::app.seo_title')</label>

            <input type="text" name="title" id="title" class="form-control" value="{{ get_config('title') }}" autocomplete="off" required>
        </div>

        <div class="form-group">
            <label class="col-form-label" for="keywords">@lang('mymo_core::app.seo_keywords')</label>
            <input type="text" name="keywords" id="keywords" class="form-control" value="{{ get_config('keywords') }}" autocomplete="off">
            <em class="description">@lang('mymo_core::app.use_comma_to_separate_keyword')</em>
        </div>

        <div class="form-group">
            <label class="col-form-label" for="description">@lang('mymo_core::app.seo_meta_description')</label>

            <textarea name="description" id="description" class="form-control" rows="4">{{ get_config('description') }}</textarea>
        </div>

        <div class="form-group">
            <label class="col-form-label" for="banner">@lang('mymo_core::app.home_banner')</label>

            <div class="row">
                <div class="col-md-10">
                    <div class="w-100" id="banner-banner">
                        <img src="{{ image_url(get_config('banner')) }}" alt="">
                    </div>
                    <em class="description">@lang('mymo_core::app.banner_display_when_sharing_on_social_networks')</em>
                    <input type="hidden" name="banner" id="banner" class="form-control" value="{{ get_config('banner') }}" autocomplete="off" >
                </div>

                <div class="col-md-2">
                    <a href="javascript:void(0)" class="btn btn-primary lfm" data-input="banner" data-preview="banner-banner"><i class="fa fa-upload"></i> @lang('mymo_core::app.choose_image')</a>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="card">
    <div class="card-header bg-primary">
        <h5 class="mb-0 card-title font-weight-bold text-white">@lang('mymo_core::app.tv_series_page_seo')</h5>
    </div>

    <div class="card-body">

        <div class="form-group">
            <label class="col-form-label" for="author_name">@lang('mymo_core::app.seo_title')</label>

            <input type="text" name="tv_series_title" id="tv_series_title" class="form-control" value="{{ get_config('tv_series_title') }}" autocomplete="off" required>
        </div>

        <div class="form-group">
            <label class="col-form-label" for="author_name">@lang('mymo_core::app.seo_keywords')</label>

            <input type="text" name="tv_series_keywords" id="tv_series_keywords" class="form-control" value="{{ get_config('tv_series_keywords') }}" autocomplete="off">
            <em class="description">@lang('mymo_core::app.use_comma_to_separate_keyword')</em>
        </div>

        <div class="form-group">
            <label class="col-form-label" for="tv_series_description">@lang('mymo_core::app.seo_meta_description')</label>
            <textarea name="tv_series_description" id="tv_series_description" class="form-control" rows="4">{{ get_config('tv_series_description') }}</textarea>
        </div>

        <div class="form-group">
            <label class="col-form-label" for="tv_series_banner">@lang('mymo_core::app.tv_series_banner')</label>

            <div class="row">
                <div class="col-md-10">
                    <div class="w-100" id="banner-tv_series">
                        <img src="{{ image_url(get_config('tv_series_banner')) }}" alt="">
                    </div>
                    <em class="description">@lang('mymo_core::app.banner_display_when_sharing_on_social_networks')</em>
                    <input type="hidden" name="tv_series_banner" id="tv_series_banner" class="form-control" value="{{ get_config('tv_series_banner') }}" autocomplete="off" >
                </div>

                <div class="col-md-2">
                    <a href="javascript:void(0)" class="btn btn-primary lfm" data-input="tv_series_banner" data-preview="banner-tv_series"><i class="fa fa-upload"></i> @lang('mymo_core::app.choose_image')</a>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="card">
    <div class="card-header bg-primary">
        <h5 class="mb-0 card-title font-weight-bold text-white">@lang('mymo_core::app.social_setting')</h5>
    </div>

    <div class="card-body">
        <div class="form-group">
            <label class="col-form-label" for="facebook">Facebook URL</label>

            <input type="text" name="facebook" id="facebook" class="form-control" value="{{ get_config('facebook') }}" autocomplete="off">
        </div>

        <div class="form-group">
            <label class="col-form-label" for="twitter">Twitter URL</label>

            <input type="text" name="twitter" id="twitter" class="form-control" value="{{ get_config('twitter') }}" autocomplete="off">
        </div>

        <div class="form-group">
            <label class="col-form-label" for="pinterest">Pinterest URL</label>

            <input type="text" name="pinterest" id="pinterest" class="form-control" value="{{ get_config('pinterest') }}" autocomplete="off">
        </div>

        <div class="form-group">
            <label class="col-form-label" for="youtube">Youtube URL</label>

            <input type="text" name="youtube" id="youtube" class="form-control" value="{{ get_config('youtube') }}" autocomplete="off">
        </div>

    </div>
</div>