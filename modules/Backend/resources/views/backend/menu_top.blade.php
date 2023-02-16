<div class="juzaweb__topbar">
    @php
        global $jw_user;
    @endphp
    <div class="mr-3">
        <a href="{{ url('/') }}" class="mr-2" target="_blank" title="{{ trans('cms::app.view_site') }}">
            <i class="dropdown-toggle-icon fa fa-home" data-toggle="tooltip" data-placement="bottom" data-original-title="Visit website"></i> {{ trans('cms::app.view_site') }}
        </a>
    </div>

    <div class="mr-3">
        <div class="dropdown mr-4 d-none d-sm-block">
            <a href="javascript:void(0)" class="dropdown-toggle text-nowrap" data-toggle="dropdown">
                <i class="fa fa-plus"></i>
                <span class="dropdown-toggle-text"> {{ trans('cms::app.new') }}</span>
            </a>

            <div class="dropdown-menu" role="menu">
                <a class="dropdown-item" href="{{ route('admin.posts.create', ['posts']) }}">{{ trans('cms::app.post') }}</a>

                <a class="dropdown-item" href="{{ route('admin.posts.create', ['pages']) }}">{{ trans('cms::app.page') }}</a>

                <a class="dropdown-item" href="{{ route('admin.users.create') }}">{{ trans('cms::app.user') }}</a>
            </div>
        </div>
    </div>

    @do_action('backend.menu_top')

    <div class="mr-auto"></div>
    @php
        $langs = \Illuminate\Support\Facades\Cache::remember(
            'top_menu_languages',
            3600,
            function () {
                return app(\Juzaweb\CMS\Support\Manager\TranslationManager::class)->locale('cms')
                    ->languages();
            }
        );

        $current = $jw_user->language ?? get_config('language', 'en');
    @endphp
    <div class="dropdown mr-4 d-none d-sm-block">
        <a href="javascript:void(0)"
           class="dropdown-toggle text-nowrap"
           data-toggle="dropdown"
           data-offset="5,15"
           aria-expanded="false"
        >
            <span class="dropdown-toggle-text text-uppercase">{{ $current }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" role="menu">
            @foreach($langs as $lang)
                @if($current == $lang['code'])
                    @continue
                @endif

            <a class="dropdown-item " href="{{ url()->current() }}?hl={{ $lang['code'] }}">
                <span class="text-uppercase font-size-12 mr-1">{{ $lang['code'] }}</span>
                {{ $lang['name'] }}</a>
            @endforeach
        </div>
    </div>

    @php
        $total = count_unread_notifications();

        $items = Auth::user()
            ->unreadNotifications()
            ->cacheFor(3600)
            ->orderBy('id', 'DESC')
            ->limit(5)
            ->get(['id', 'data', 'created_at']);
    @endphp

    <div class="juzaweb__topbar__notify dropdown mr-4 d-none d-sm-block">
        <a href="javascript:void(0)" class="dropdown-toggle text-nowrap" data-toggle="dropdown" aria-expanded="false" data-offset="0,15">
            <i class="dropdown-toggle-icon fa fa-bell-o"></i> <span>{{ $total }}</span>
        </a>

        <div class="juzaweb__topbar__actionsDropdownMenu dropdown-menu dropdown-menu-right" role="menu">
            <div style="width: 350px;">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="jw__l1">
                            <div class="text-uppercase mb-2 text-gray-6 mb-2 font-weight-bold">{{ trans('cms::app.notifications') }} ({{ $total }})</div>
                            <hr>
                            <ul class="list-unstyled">
                                @if($items->isEmpty())
                                    <p>{{ trans('cms::app.no_notifications') }}</p>
                                @else
                                    @foreach($items as $notify)
                                        <li class="jw__l8__item">
                                            <a href="{{ route('admin.profile.notification', [$notify->id]) }}" class="jw__l8__itemLink" data-turbolinks="false">
                                                <div class="jw__l8__itemPic bg-success">
                                                    @if(empty($notify->data['image']))
                                                        <i class="fa fa-envelope-square"></i>
                                                    @else
                                                        <img src="{{ upload_url($notify->data['image']) }}" alt="">
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="text-blue">{{ $notify->data['subject'] ?? '' }}</div>
                                                    <div class="text-muted">{{ $notify->created_at?->diffForHumans() }}</div>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="dropdown">
        <a href="" class="dropdown-toggle text-nowrap" data-toggle="dropdown" aria-expanded="false" data-offset="5,15">
            <img class="dropdown-toggle-avatar" src="{{ $jw_user->getAvatar() }}" alt="User avatar" width="30" height="30"/>
        </a>

        <div class="dropdown-menu dropdown-menu-right" role="menu">
            <a class="dropdown-item" href="{{ route('admin.profile') }}">
                <i class="dropdown-icon fa fa-user"></i>
                {{ trans('cms::app.profile') }}
            </a>

            <div class="dropdown-divider"></div>
            <a href="javascript:void(0)" data-turbolinks="false" class="dropdown-item auth-logout">
                <i class="dropdown-icon fa fa-sign-out"></i> {{ trans('cms::app.logout') }}
            </a>
        </div>
    </div>
</div>
