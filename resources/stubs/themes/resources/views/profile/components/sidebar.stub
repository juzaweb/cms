<aside id="sidebar" class="col-xs-12 col-sm-12 col-md-4">
    <div class="section-bar clearfix">
        <div class="profile-sidebar">
            <!-- SIDEBAR USERPIC -->
            <div class="profile-userpic">
                <img alt="Avatar"
                     src='https://1.gravatar.com/avatar/7162c5aa667c497c4d1b90b36c60eaea?s=200&#038;d=mm&#038;r=g'
                     srcset='https://1.gravatar.com/avatar/7162c5aa667c497c4d1b90b36c60eaea?s=400&#038;d=mm&#038;r=g 2x'
                     class='avatar avatar-200 photo' height='200' width='200'/>
            </div>
            <!-- END SIDEBAR USERPIC -->
            <!-- SIDEBAR USER TITLE -->
            <div class="profile-usertitle">
                <div class="profile-usertitle-name">
                    <a href="{{ home_url('profile') }}"></a>
                </div>
                <div class="profile-usertitle-job">
                    subscriber
                </div>
            </div>
            <!-- END SIDEBAR USER TITLE -->
            <!-- SIDEBAR BUTTONS -->

            <!-- END SIDEBAR BUTTONS -->
            <!-- SIDEBAR MENU -->
            <div class="profile-usermenu">
                <ul class="nav flex-column">
                    <li class="nav-item {{ request()->is('profile') ? 'active' : '' }}">
                        <a href="{{ home_url('profile') }}">
                            <i class="fas fa-user"></i> {{ __('video-sharing::translation.profile') }}
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('profile/notification') ? 'active' : '' }}">
                        <a href="{{ home_url('profile') }}/notification">
                            <i class="fas fa-bell"></i> {{ __('video-sharing::translation.notification') }}</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-turbolinks="false" onclick="$('.form-logout').submit()">
                            <i class="fas fa-sign-out-alt"></i> {{ __('video-sharing::translation.logout') }}</a>
                    </li>
                </ul>
            </div>

            <!-- END MENU -->
        </div>
    </div>
</aside>

