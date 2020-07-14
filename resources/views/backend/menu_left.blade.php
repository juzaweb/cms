<ul class="cui__menuLeft__navigation" data-turbolinks-track="reload">
    <li class="cui__menuLeft__item">
        <a class="cui__menuLeft__item__link @if(request()->is('admin-cp')) cui__menuLeft__item--active @endif" href="{{ route('admin.dashboard') }}">
            <span class="cui__menuLeft__item__title">@lang('app.dashboard')</span>
            <i class="cui__menuLeft__item__icon fe fe-home"></i>
        </a>
    </li>

    <li class="cui__menuLeft__item">
        <a class="cui__menuLeft__item__link @if(request()->is('admin-cp/movies*')) cui__menuLeft__item--active @endif" href="{{ route('admin.movies') }}">
            <span class="cui__menuLeft__item__title">@lang('app.movies')</span>
            <i class="cui__menuLeft__item__icon fe fe-film"></i>
        </a>
    </li>

    <li class="cui__menuLeft__item">
        <a class="cui__menuLeft__item__link @if(request()->is('admin-cp/tv-series*')) cui__menuLeft__item--active @endif" href="{{ route('admin.tv_series') }}">
            <span class="cui__menuLeft__item__title">@lang('app.tv_series')</span>
            <i class="cui__menuLeft__item__icon fe fe-film"></i>
        </a>
    </li>

    <li class="cui__menuLeft__item">
        <a class="cui__menuLeft__item__link @if(request()->is('admin-cp/genres*')) cui__menuLeft__item--active @endif" href="{{ route('admin.genres') }}">
            <span class="cui__menuLeft__item__title">@lang('app.genres')</span>
            <i class="cui__menuLeft__item__icon fe fe-list"></i>
        </a>
    </li>

    <li class="cui__menuLeft__item">
        <a class="cui__menuLeft__item__link @if(request()->is('admin-cp/countries*')) cui__menuLeft__item--active @endif" href="{{ route('admin.countries') }}">
            <span class="cui__menuLeft__item__title">@lang('app.countries')</span>
            <i class="cui__menuLeft__item__icon fe fe-list"></i>
        </a>
    </li>

    <li class="cui__menuLeft__item">
        <a class="cui__menuLeft__item__link @if(request()->is('admin-cp/types*')) cui__menuLeft__item--active @endif" href="{{ route('admin.types') }}">
            <span class="cui__menuLeft__item__title">@lang('app.types')</span>
            <i class="cui__menuLeft__item__icon fe fe-list"></i>
        </a>
    </li>

    <li class="cui__menuLeft__item">
        <a class="cui__menuLeft__item__link @if(request()->is('admin-cp/stars*')) cui__menuLeft__item--active @endif" href="{{ route('admin.stars') }}">
            <span class="cui__menuLeft__item__title">@lang('app.stars')</span>
            <i class="cui__menuLeft__item__icon fe fe-star"></i>
        </a>
    </li>

    <li class="cui__menuLeft__item">
        <a class="cui__menuLeft__item__link @if(request()->is('admin-cp/pages*')) cui__menuLeft__item--active @endif" href="{{ route('admin.pages') }}">
            <span class="cui__menuLeft__item__title">@lang('app.pages')</span>
            <i class="cui__menuLeft__item__icon fe fe-clipboard"></i>
        </a>
    </li>

    <li class="cui__menuLeft__item cui__menuLeft__submenu @if(request()->is('admin-cp/posts*') || request()->is('admin-cp/post-categories*')) cui__menuLeft__submenu--toggled @endif">
        <span class="cui__menuLeft__item__link">
            <span class="cui__menuLeft__item__title">@lang('app.posts')</span>
            <i class="cui__menuLeft__item__icon fe fe-clipboard"></i>
        </span>
        <ul class="cui__menuLeft__navigation" @if(request()->is('admin-cp/posts*') || request()->is('admin-cp/post-categories*')) style="display: block" @endif>
            <li class="cui__menuLeft__item">
                <a class="cui__menuLeft__item__link @if(request()->is('admin-cp/posts*')) cui__menuLeft__item--active @endif" href="{{ route('admin.posts') }}">
                    <span class="cui__menuLeft__item__title">@lang('app.posts')</span>
                </a>
            </li>

            <li class="cui__menuLeft__item">
                <a class="cui__menuLeft__item__link @if(request()->is('admin-cp/post-categories*')) cui__menuLeft__item--active @endif" href="{{ route('admin.post_categories') }}">
                    <span class="cui__menuLeft__item__title">@lang('app.categories')</span>
                </a>
            </li>

        </ul>
    </li>

    <li class="cui__menuLeft__item">
        <a class="cui__menuLeft__item__link @if(request()->is('admin-cp/users*')) cui__menuLeft__item--active @endif" href="{{ route('admin.users') }}">
            <span class="cui__menuLeft__item__title">@lang('app.users')</span>
            <i class="cui__menuLeft__item__icon fe fe-users"></i>
        </a>
    </li>

    <li class="cui__menuLeft__item cui__menuLeft__submenu">
        <span class="cui__menuLeft__item__link">
            <span class="cui__menuLeft__item__title">@lang('app.comments')</span>
            <i class="cui__menuLeft__item__icon fe fe-message-square"></i>
        </span>
        <ul class="cui__menuLeft__navigation">
            <li class="cui__menuLeft__item">
                <a href="{{ route('admin.movie_comments') }}" class="cui__menuLeft__item__link">
                    <span class="cui__menuLeft__item__title">@lang('app.movie_comments')</span>
                </a>
            </li>

            <li class="cui__menuLeft__item">
                <a href="{{ route('admin.post_comments') }}" class="cui__menuLeft__item__link">
                    <span class="cui__menuLeft__item__title">@lang('app.post_comments')</span>
                </a>
            </li>

            <li class="cui__menuLeft__item">
                <a href="{{ route('admin.setting.comment') }}" class="cui__menuLeft__item__link">
                    <span class="cui__menuLeft__item__title">@lang('app.setting')</span>
                </a>
            </li>
        </ul>
    </li>

    <li class="cui__menuLeft__item cui__menuLeft__submenu">
        <span class="cui__menuLeft__item__link">
            <span class="cui__menuLeft__item__title">@lang('app.theme')</span>
            <i class="cui__menuLeft__item__icon fe fe-layout"></i>
        </span>
        <ul class="cui__menuLeft__navigation">
            <li class="cui__menuLeft__item">
                <a href="{{ route('admin.theme.themes') }}" class="cui__menuLeft__item__link">
                    <span class="cui__menuLeft__item__title">@lang('app.themes')</span>
                </a>
            </li>

            <li class="cui__menuLeft__item">
                <a href="{{ route('admin.theme.menu') }}" class="cui__menuLeft__item__link">
                    <span class="cui__menuLeft__item__title">@lang('app.menu')</span>
                </a>
            </li>

            <li class="cui__menuLeft__item">
                <a href="{{ route('admin.theme.editor') }}" class="cui__menuLeft__item__link" data-turbolinks="false">
                    <span class="cui__menuLeft__item__title">@lang('app.editor')</span>
                </a>
            </li>

        </ul>
    </li>

    <li class="cui__menuLeft__item cui__menuLeft__submenu @if(request()->is('admin-cp/setting*')) cui__menuLeft__submenu--toggled @endif">
        <span class="cui__menuLeft__item__link">
            <span class="cui__menuLeft__item__title">@lang('app.setting')</span>
            <i class="cui__menuLeft__item__icon fe fe-settings"></i>
        </span>
        <ul class="cui__menuLeft__navigation" @if(request()->is('admin-cp/setting*')) style="display: block" @endif>

            <li class="cui__menuLeft__item">
                <a href="{{ route('admin.setting') }}" class="cui__menuLeft__item__link">
                    <span class="cui__menuLeft__item__title">@lang('app.system_setting')</span>
                </a>
            </li>

            <li class="cui__menuLeft__item">
                <a href="{{ route('admin.setting.seo') }}" class="cui__menuLeft__item__link">
                    <span class="cui__menuLeft__item__title">@lang('app.seo_and_socials')</span>
                </a>
            </li>

            <li class="cui__menuLeft__item">
                <a href="{{ route('admin.setting.email') }}" class="cui__menuLeft__item__link">
                    <span class="cui__menuLeft__item__title">@lang('app.email_setting')</span>
                </a>
            </li>

            <li class="cui__menuLeft__item">
                <a href="{{ route('admin.video_qualities') }}" class="cui__menuLeft__item__link">
                    <span class="cui__menuLeft__item__title">@lang('app.video_qualities')</span>
                </a>
            </li>

            <li class="cui__menuLeft__item">
                <a href="{{ route('admin.setting.ads') }}" class="cui__menuLeft__item__link">
                    <span class="cui__menuLeft__item__title">@lang('app.banner_ads')</span>
                </a>
            </li>

            <li class="cui__menuLeft__item">
                <a href="{{ route('admin.setting.video_ads') }}" class="cui__menuLeft__item__link">
                    <span class="cui__menuLeft__item__title">@lang('app.video_ads')</span>
                </a>
            </li>

            <li class="cui__menuLeft__item">
                <a href="{{ route('admin.setting.languages') }}" class="cui__menuLeft__item__link">
                    <span class="cui__menuLeft__item__title">@lang('app.language')</span>
                </a>
            </li>
        </ul>
    </li>

    <li class="cui__menuLeft__item">
        <a href="{{ route('admin.notification') }}" class="cui__menuLeft__item__link">
            <span class="cui__menuLeft__item__title">@lang('app.notification')</span>
            <i class="cui__menuLeft__item__icon fe fe-users"></i>
        </a>
    </li>

    <li class="cui__menuLeft__item cui__menuLeft__submenu">
        <span class="cui__menuLeft__item__link">
            <span class="cui__menuLeft__item__title">@lang('app.logs')</span>
            <i class="cui__menuLeft__item__icon fe fe-layout"></i>
        </span>
        <ul class="cui__menuLeft__navigation">
            <li class="cui__menuLeft__item">
                <a href="{{ route('admin.email_logs') }}" class="cui__menuLeft__item__link">
                    <span class="cui__menuLeft__item__title">@lang('app.email_logs')</span>
                </a>
            </li>

            <li class="cui__menuLeft__item">
                <a href="/log-viewer" target="_blank" data-turbolinks="false" class="cui__menuLeft__item__link">
                    <span class="cui__menuLeft__item__title">@lang('app.error_logs')</span>
                </a>
            </li>

        </ul>
    </li>
</ul>