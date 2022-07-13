@extends('cms::layouts.backend')

@section('content')
    <form method="post" action="" class="form-ajax">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#home-tab">
                    {{ trans('cms::app.general') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane p-2 active" role="tabpanel" aria-labelledby="home-tab">
                <p>You can enable / disable some of them below. Clicking the question mark gives more information about the feature.</p>

                {{ Field::checkbox('XML sitemaps', 'config[jw_sitemap_enable]', [
                    'value' => 1,
                    'checked' => config('jw_sitemap_enable') == 1,
                    'description' => 'Enable the XML sitemaps that Yoast SEO generates. <a href="/sitemap.xml" target="_blank">See the XML sitemap</a>'
                ]) }}
            </div>
        </div>
    </form>
@endsection
