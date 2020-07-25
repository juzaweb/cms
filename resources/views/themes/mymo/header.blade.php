<header id="header">
    <div class="container">
        <div class="row" id="headwrap">
            <div class="col-md-3 col-sm-6 slogan">
                <h1 class="site-title"><a class="logo" href="/" rel="home">{{ $home_tile }}</a></h1>
            </div>

            <div class="col-md-5 col-sm-6 halim-search-form hidden-xs">
                <div class="header-nav">
                    <div class="col-xs-12">
                        <form id="search-form-pc" name="halimForm" role="search" action="/" method="GET">
                            <div class="form-group">
                                <div class="input-group col-xs-12">
                                    <input id="search" type="text" name="s" value="" class="form-control" data-toggle="tooltip" data-placement="bottom" data-original-title="Nhấn Enter để tìm kiếm" placeholder="Tìm kiếm với 3,119 bộ phim..." autocomplete="off" required>
                                    <i class="animate-spin hl-spin4 hidden"></i>
                                </div>
                            </div>
                        </form>
                        <ul class="ui-autocomplete ajax-results hidden"></ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4 hidden-xs">
                <div id="get-bookmark" class="box-shadow">
                    <i class="hl-bookmark"></i><span> @lang('app.bookmark')</span>
                    <span class="count">0</span>
                </div>
                <div class="user user-login-option box-shadow" id="pc-user-login">
                    <div class="dropdown">
                        @if(Auth::check())
                            <a href="javascript:void(0)" class="avt" id="userInfo2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <img src='http://1.gravatar.com/avatar/?s=20&#038;d=mm&#038;r=g' srcset='http://2.gravatar.com/avatar/?s=40&#038;d=mm&#038;r=g 2x' class='avatar avatar-20 photo avatar-default' height='20' width='20' />
                                <span class="name">@lang('app.account')</span>
                            </a>
                            <ul class="dropdown-menu login-box" aria-labelledby="userInfo2">
                                @if(\App\User::find(Auth::id())->is_admin)
                                    <li><a href="{{ route('admin.dashboard') }}" data-turbolinks="false"><i class="hl-cog"></i> @lang('app.admin_panel')</a></li>
                                @endif

                                <li><a href="{{ route('account') }}"><i class="hl-user"></i> @lang('app.profile')</a></li>

                                <li><a href="{{ route('logout') }}" data-turbolinks="false"><i class="hl-off"></i> @lang('app.logout')</a></li>
                            </ul>
                        @else
                        <a href="javascript:void(0)" class="avt" id="userInfo">
                            <img src='http://1.gravatar.com/avatar/?s=20&#038;d=mm&#038;r=g' srcset='http://2.gravatar.com/avatar/?s=40&#038;d=mm&#038;r=g 2x' class='avatar avatar-20 photo avatar-default' height='20' width='20' />
                            <span class="name">@lang('app.login')</span>
                        </a>
                        @endif
                    </div>
                </div>
                <div id="bookmark-list" class="hidden bookmark-list-on-pc"><ul style="margin: 0;"></ul></div>
            </div>

        </div>
    </div>
</header>
