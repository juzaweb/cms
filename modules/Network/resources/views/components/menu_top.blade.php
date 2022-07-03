<div class="juzaweb__topbar">
    <div class="mr-3">
        <a href="{{ route('admin.dashboard') }}" class="mr-2" title="{{ trans('cms::app.dashboard') }}" data-turbolinks="false">
            <i class="dropdown-toggle-icon fa fa-dashboard" data-toggle="tooltip" data-placement="bottom" data-original-title="Visit website"></i> {{ trans('cms::app.admin') }}
        </a>

        <a href="{{ url('/') }}" class="mr-2" target="_blank" title="{{ trans('cms::app.view_site') }}">
            <i class="dropdown-toggle-icon fa fa-home" data-toggle="tooltip" data-placement="bottom" data-original-title="Visit website"></i> {{ trans('cms::app.view_site') }}
        </a>
    </div>

    <div class="mr-auto"></div>

    @php
        $total = count_unread_notifications();

        $items = Auth::user()
            ->unreadNotifications()
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
                                    <p>@lang('cms::app.no_notifications')</p>
                                @else
                                    @foreach($items as $notify)
                                        <li class="jw__l8__item">
                                            <a href="{{ @$notify->data['url'] }}" class="jw__l8__itemLink" data-turbolinks="false"
                                            >
                                                <div class="jw__l8__itemPic bg-success">
                                                    @if(empty($notify->data['image']))
                                                        <i class="fa fa-envelope-square"></i>
                                                    @else
                                                        <img src="{{ upload_url($notify->data['image']) }}" alt="">
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="text-blue">{{ @$notify->data['subject'] }}</div>
                                                    <div class="text-muted">{{ $notify->created_at ? $notify->created_at->diffForHumans() : '' }}</div>
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

    @php
        global $jw_user;
    @endphp
    <div class="dropdown">
        <a href="" class="dropdown-toggle text-nowrap" data-toggle="dropdown" aria-expanded="false" data-offset="5,15">
            <img class="dropdown-toggle-avatar" src="{{ $jw_user->getAvatar() }}" alt="User avatar" width="30" height="30"/>
        </a>

        <div class="dropdown-menu dropdown-menu-right" role="menu">
            <a
                class="dropdown-item"
                href="{{ route('admin.users.edit', [$jw_user->id]) }}"
                data-turbolinks="false"
            >
                <i class="dropdown-icon fe fe-user"></i>
                {{ trans('cms::app.profile') }}
            </a>

            <div class="dropdown-divider"></div>
            <a href="javascript:void(0)" data-turbolinks="false" class="dropdown-item auth-logout">
                <i class="dropdown-icon fe fe-log-out"></i> {{ trans('cms::app.logout') }}
            </a>
        </div>
    </div>
</div>
