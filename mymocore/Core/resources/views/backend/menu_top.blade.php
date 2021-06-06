<div class="cui__topbar">
    <div class="mr-4">

    </div>
    <div class="mr-auto">
        {{--<div class="cui__topbar__search">
            <i class="fe fe-search">
                <!-- --></i>
            <input type="text" placeholder="Type to search..." />
        </div>--}}
    </div>

    <div class="mr-4 d-none d-md-block">
        <a href="/" data-turbolinks="false" target="_blank" class="text-nowrap">
            <span>VIEW WEBSITE</span>
        </a>
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
    <div class="cui__topbar__actionsDropdown dropdown mr-4 d-none d-sm-block">
        <a href="javascript:void(0)" class="dropdown-toggle text-nowrap" data-toggle="dropdown" aria-expanded="false" data-offset="0,15">
            <i class="dropdown-toggle-icon fe fe-bell"></i>
        </a>
        <div class="cui__topbar__actionsDropdownMenu dropdown-menu dropdown-menu-right" role="menu">
            <div style="width: 350px;">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="height-300 kit__customScroll">
                            <ul class="list-unstyled">

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
            {{--<a href="{{ route('logout') }}" class="dropdown-item" data-turbolinks="false">
                <i class="dropdown-icon fe fe-log-out"></i> @lang('mymo_core::app.logout')
            </a>--}}
        </div>
    </div>
</div>