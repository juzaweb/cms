<form method="post" action="{{ route('admin.setting.save') }}" class="form-ajax">
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

    <div class="form-group">
        <label class="col-form-label" for="fb_app_id">@lang('app.fb_app_id')</label>

        <input type="text" name="fb_app_id" class="form-control" id="fb_app_id" value="{{ get_config('fb_app_id') }}" autocomplete="off">
    </div>

    <div class="form-group">
        <label class="col-form-label" for="google_analytics">@lang('app.google_analytics_id')</label>

        <input type="text" name="google_analytics" class="form-control" id="google_analytics" value="{{ get_config('google_analytics') }}" autocomplete="off">
    </div>

    <div class="row">
        <div class="col-md-6"></div>

        <div class="col-md-6">
            <div class="btn-group float-right">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-save"></i> @lang('app.save')
                </button>

                <button type="reset" class="btn btn-default">
                    <i class="fa fa-refresh"></i> @lang('app.reset')
                </button>
            </div>
        </div>
    </div>
</form>