<div class="card">
    <div class="card-header bg-primary">
        <h5 class="mb-0 card-title font-weight-bold text-white">@lang('mymo::app.basic_seo')</h5>
    </div>

    <div class="card-body">

        <div class="form-group">
            <label class="col-form-label" for="sitemap">@lang('mymo::app.sitemap')</label>

            <p><a href="{{ route('sitemap') }}" data-turbolinks="false" target="_blank">{{ route('sitemap') }}</a></p>
        </div>

        <div class="form-group">
            <label class="col-form-label" for="author_name">@lang('mymo::app.author_name')</label>

            <input type="text" name="author_name" id="author_name" class="form-control" value="{{ get_config('author_name') }}" autocomplete="off" required>
        </div>

    </div>
</div>

<div class="card">
    <div class="card-header bg-primary">
        <h5 class="mb-0 card-title font-weight-bold text-white">@lang('mymo::app.movies_page_seo')</h5>
    </div>

    <div class="card-body">

        <div class="form-group">
            <label class="col-form-label" for="movies_title">@lang('mymo::app.seo_title')</label>

            <input type="text" name="movies_title" id="movies_title" class="form-control" value="{{ get_config('movies_title') }}" autocomplete="off" required>
        </div>

        <div class="form-group">
            <label class="col-form-label" for="movies_keywords">@lang('mymo::app.seo_keywords')</label>

            <input type="text" name="movies_keywords" id="movies_keywords" class="form-control" value="{{ get_config('movies_keywords') }}" autocomplete="off">
            <em class="description">@lang('mymo::app.use_comma_to_separate_keyword')</em>
        </div>

        <div class="form-group">
            <label class="col-form-label" for="movies_description">@lang('mymo::app.seo_meta_description')</label>

            <textarea name="movies_description" id="movies_description" class="form-control" rows="4">{{ get_config('movies_description') }}</textarea>
        </div>

        <div class="form-group">
            <label class="col-form-label" for="movies_banner">@lang('mymo::app.movies_banner')</label>

            <div class="row">
                <div class="col-md-10">
                    <div class="w-100" id="banner-movies">
                        <img src="{{ image_url(get_config('movies_banner')) }}" alt="">
                    </div>
                    <em class="description">@lang('mymo::app.banner_display_when_sharing_on_social_networks')</em>
                    <input type="hidden" name="movies_banner" id="movies_banner" class="form-control" value="{{ get_config('movies_banner') }}" autocomplete="off" >
                </div>

                <div class="col-md-2">
                    <a href="javascript:void(0)" class="btn btn-primary lfm" data-input="movies_banner" data-preview="banner-movies"><i class="fa fa-upload"></i> @lang('mymo::app.choose_image')</a>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="card">
    <div class="card-header bg-primary">
        <h5 class="mb-0 card-title font-weight-bold text-white">@lang('mymo::app.blog_page_seo')</h5>
    </div>

    <div class="card-body">
        <div class="form-group">
            <label class="col-form-label" for="blog_title">@lang('mymo::app.seo_title')</label>

            <input type="text" name="blog_title" id="blog_title" class="form-control" value="{{ get_config('blog_title') }}" autocomplete="off" required>
        </div>

        <div class="form-group">
            <label class="col-form-label" for="blog_keywords">@lang('mymo::app.seo_keywords')</label>

            <input type="text" name="blog_keywords" id="blog_keywords" class="form-control" value="{{ get_config('blog_keywords') }}" autocomplete="off">
            <em class="description">@lang('mymo::app.use_comma_to_separate_keyword')</em>
        </div>

        <div class="form-group">
            <label class="col-form-label" for="blog_description">@lang('mymo::app.seo_meta_description')</label>

            <textarea name="blog_description" id="blog_description" class="form-control" rows="4">{{ get_config('blog_description') }}</textarea>
        </div>

        <div class="form-group">
            <label class="col-form-label" for="blog_banner">@lang('mymo::app.blog_banner')</label>

            <div class="row">
                <div class="col-md-10">
                    <div class="w-100" id="banner-blog">
                        <img src="{{ image_url(get_config('blog_banner')) }}" alt="">
                    </div>
                    <em class="description">@lang('mymo::app.banner_display_when_sharing_on_social_networks')</em>
                    <input type="hidden" name="blog_banner" id="blog_banner" class="form-control" value="{{ get_config('blog_banner') }}" autocomplete="off" >
                </div>

                <div class="col-md-2">
                    <a href="javascript:void(0)" class="btn btn-primary lfm" data-input="blog_banner" data-preview="banner-blog"><i class="fa fa-upload"></i> @lang('mymo::app.choose_image')</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-primary">
        <h5 class="mb-0 card-title font-weight-bold text-white">@lang('mymo::app.latest_movies_page_seo')</h5>
    </div>

    <div class="card-body">
        <div class="form-group">
            <label class="col-form-label" for="blog_title">@lang('mymo::app.seo_title')</label>

            <input type="text" name="latest_movies_title" id="latest_movies_title" class="form-control" value="{{ get_config('latest_movies_title') }}" autocomplete="off" required>
        </div>

        <div class="form-group">
            <label class="col-form-label" for="blog_keywords">@lang('mymo::app.seo_keywords')</label>

            <input type="text" name="latest_movies_keywords" id="latest_movies_keywords" class="form-control" value="{{ get_config('latest_movies_keywords') }}" autocomplete="off">
            <em class="description">@lang('mymo::app.use_comma_to_separate_keyword')</em>
        </div>

        <div class="form-group">
            <label class="col-form-label" for="latest_movies_description">@lang('mymo::app.seo_meta_description')</label>

            <textarea name="latest_movies_description" id="latest_movies_description" class="form-control" rows="4">{{ get_config('latest_movies_description') }}</textarea>
        </div>

        <div class="form-group">
            <label class="col-form-label" for="latest_movies_banner">@lang('mymo::app.latest_movies_banner')</label>

            <div class="row">
                <div class="col-md-10">
                    <div class="w-100" id="banner-latest_movies">
                        <img src="{{ image_url(get_config('latest_movies_banner')) }}" alt="">
                    </div>
                    <em class="description">@lang('mymo::app.banner_display_when_sharing_on_social_networks')</em>
                    <input type="hidden" name="latest_movies_banner" id="latest_movies_banner" class="form-control" value="{{ get_config('latest_movies_banner') }}" autocomplete="off" >
                </div>

                <div class="col-md-2">
                    <a href="javascript:void(0)" class="btn btn-primary lfm" data-input="latest_movies_banner" data-preview="banner-latest_movies"><i class="fa fa-upload"></i> @lang('mymo::app.choose_image')</a>
                </div>
            </div>
        </div>
    </div>
</div>