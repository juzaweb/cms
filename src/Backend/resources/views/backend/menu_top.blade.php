<div class="mymo__topbar">
    <div class="mr-4">
        <a href="{{ url('/') }}" class="mr-2" target="_blank">
            <i class="dropdown-toggle-icon fa fa-home" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Visit website"></i> Visit Site
        </a>
    </div>

    <div class="mr-auto">
        <div class="dropdown mr-4 d-none d-sm-block">
            <a href="javascript:void(0)" class="dropdown-toggle text-nowrap" data-toggle="dropdown">
                <i class="fa fa-plus"></i>
                <span class="dropdown-toggle-text"> New</span>
            </a>

            <div class="dropdown-menu" role="menu">
                <a class="dropdown-item" href="{{ route('admin.posts.create') }}">@lang('mymo_core::app.post')</a>
                <a class="dropdown-item" href="{{ route('admin.page.create') }}">@lang('mymo_core::app.page')</a>
                <a class="dropdown-item" href="{{ route('admin.users.create') }}">@lang('mymo_core::app.user')</a>
            </div>
        </div>
    </div>

    <div class="dropdown mr-4 d-none d-sm-block">
        <a href="" class="dropdown-toggle text-nowrap" data-toggle="dropdown" data-offset="5,15">
            <span class="dropdown-toggle-text">EN</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" role="menu">
            <a class="dropdown-item " href="javascript:void(0)"><span class="text-uppercase font-size-12 mr-1">EN</span>
                English</a>
        </div>
    </div>
    <div class="mymo__topbar__actionsDropdown dropdown mr-4 d-none d-sm-block">
        <a href="javascript:void(0)" class="dropdown-toggle text-nowrap" data-toggle="dropdown" aria-expanded="false" data-offset="0,15">
            <i class="dropdown-toggle-icon fa fa-bell-o"></i>
        </a>
        @php
            $total = Auth::user()
                        ->unreadNotifications()
                        ->count();

            $items = Auth::user()
            ->unreadNotifications()
            ->orderBy('id', 'DESC')
            ->limit(5)
            ->get(['id', 'data', 'created_at']);
        @endphp
        <div class="mymo__topbar__actionsDropdownMenu dropdown-menu dropdown-menu-right" role="menu">
            <div style="width: 350px;">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="kit__l1">
                            <div class="text-uppercase mb-2 text-gray-6 mb-2 font-weight-bold">@lang('mymo_core::app.notifications') ({{ $total }})</div>
                            <hr>
                            <ul class="list-unstyled">
                                @if($items->isEmpty())
                                    <p>@lang('mymo_core::app.no_notifications')</p>
                                @else
                                    @foreach($items as $notify)
                                        <li class="kit__l1__item">
                                            <a href="{{ @$notify->data['url'] }}" class="kit__l1__itemLink" data-turbolinks="false">
                                                <div class="kit__l1__itemPic mr-3">
                                                    @if(empty($notify->data['image']))
                                                        <i class="kit__l1__itemIcon fa fa-envelope-square"></i>
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

    <div class="dropdown">
        <a href="" class="dropdown-toggle text-nowrap" data-toggle="dropdown" aria-expanded="false" data-offset="5,15">
            <img class="dropdown-toggle-avatar" src="{{ user_avatar() }}" alt="User avatar" width="30" height="30"/>
        </a>

        <div class="dropdown-menu dropdown-menu-right" role="menu">
            <a class="dropdown-item" href="{{ route('admin.users.edit', [Auth::id()]) }}">
                <i class="dropdown-icon fe fe-user"></i>
                @lang('mymo_core::app.profile')
            </a>

            <div class="dropdown-divider"></div>
            <a href="{{ route('auth.logout') }}" class="dropdown-item" data-turbolinks="false">
                <i class="dropdown-icon fe fe-log-out"></i> @lang('mymo_core::app.logout')
            </a>
        </div>
    </div>
</div>