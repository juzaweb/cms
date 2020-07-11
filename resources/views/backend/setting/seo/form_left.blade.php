<div class="card">
    <div class="card-header bg-primary">
        <h5 class="mb-0 card-title font-weight-bold text-white">@lang('app.basic_seo')</h5>
    </div>

    <div class="card-body">

        <div class="form-group">
            <label class="col-form-label" for="sitemap">@lang('app.sitemap')</label>

            <p><a href=""></a></p>
        </div>

        <div class="form-group">
            <label class="col-form-label" for="author_name">@lang('app.author_name')</label>

            <input type="text" name="author_name" id="author_name" class="form-control" value="{{ get_config('author_name') }}" autocomplete="off" required>
        </div>

    </div>
</div>

<div class="card">
    <div class="card-header bg-primary">
        <h5 class="mb-0 card-title font-weight-bold text-white">@lang('app.movies_page_seo')</h5>
    </div>

    <div class="card-body">

        <div class="form-group">
            <label class="col-form-label" for="author_name">@lang('app.seo_title')</label>

            <input type="text" name="movies_title" id="movies_title" class="form-control" value="{{ get_config('movies_title') }}" autocomplete="off" required>
        </div>

        <div class="form-group">
            <label class="col-form-label" for="author_name">@lang('app.seo_keywords')</label>

            <input type="text" name="movies_keywords" id="movies_keywords" class="form-control" value="{{ get_config('movies_keywords') }}" autocomplete="off">
            <em class="description">@lang('app.use_comma_to_separate_keyword')</em>
        </div>

        <div class="form-group">
            <label class="col-form-label" for="movies_description">@lang('app.seo_meta_description')</label>

            <textarea name="movies_description" id="movies_description" class="form-control" rows="4">{{ get_config('movies_description') }}</textarea>
        </div>

    </div>
</div>

<div class="card">
    <div class="card-header bg-primary">
        <h5 class="mb-0 card-title font-weight-bold text-white">@lang('app.blog_page_seo')</h5>
    </div>

    <div class="card-body">
        <div class="form-group">
            <label class="col-form-label" for="blog_title">@lang('app.seo_title')</label>

            <input type="text" name="blog_title" id="blog_title" class="form-control" value="{{ get_config('blog_title') }}" autocomplete="off" required>
        </div>

        <div class="form-group">
            <label class="col-form-label" for="blog_keywords">@lang('app.seo_keywords')</label>

            <input type="text" name="blog_keywords" id="blog_keywords" class="form-control" value="{{ get_config('blog_keywords') }}" autocomplete="off">
            <em class="description">@lang('app.use_comma_to_separate_keyword')</em>
        </div>

        <div class="form-group">
            <label class="col-form-label" for="blog_description">@lang('app.seo_meta_description')</label>

            <textarea name="blog_description" id="blog_description" class="form-control" rows="4">{{ get_config('blog_description') }}</textarea>
        </div>
    </div>
</div>