<aside id="sidebar" class="col-xs-12 col-sm-12 col-md-4">
    <div class="section-bar clearfix">
        <h3 class="section-title">
            <span>@lang('theme::app.profile')</span>
        </h3>

        <div class="profile-sidebar">
            <!-- SIDEBAR USERPIC -->
            <div class="profile-userpic">
                <img alt='' src='http://1.gravatar.com/avatar/7162c5aa667c497c4d1b90b36c60eaea?s=200&#038;d=mm&#038;r=g' srcset='http://1.gravatar.com/avatar/7162c5aa667c497c4d1b90b36c60eaea?s=400&#038;d=mm&#038;r=g 2x' class='avatar avatar-200 photo' height='200' width='200' />				</div>
            <!-- END SIDEBAR USERPIC -->
            <!-- SIDEBAR USER TITLE -->
            <div class="profile-usertitle">
                <div class="profile-usertitle-name">
                    <a href="{{ route('account') }}"></a>
                </div>
                <div class="profile-usertitle-job">
                    subscriber
                </div>
            </div>
            <!-- END SIDEBAR USER TITLE -->
            <!-- SIDEBAR BUTTONS -->
        {{--<div class="profile-userbuttons">
            <button type="button" class="btn btn-success btn-sm" data-toggle="tooltip" title="">Follow</button>
            <button type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" title="">Message</button>
        </div>--}}
        <!-- END SIDEBAR BUTTONS -->
            <!-- SIDEBAR MENU -->
            <div class="profile-usermenu">
                <ul class="nav">
                    <li @if(request()->is('account')) class="active" @endif>
                        <a href="{{ route('account') }}"><i class="hl-user"></i> @lang('theme::app.profile')</a>
                    </li>

                    <li @if(request()->is('account/notification*')) class="active" @endif>
                        <a href="{{ route('account.notification') }}"><i class="hl-bell"></i> @lang('theme::app.notification')</a>
                    </li>

                    <li @if(request()->is('account/change-password')) class="active" @endif>
                        <a href="{{ route('account.change_password') }}"><i class="hl-lock-open-alt"></i> @lang('theme::app.change_password')</a>
                    </li>

                    <li>
                        <a href="{{ route('logout') }}" data-turbolinks="false"><i class="hl-off"></i> @lang('theme::app.logout')</a>
                    </li>
                </ul>
            </div>
            <!-- END MENU -->
        </div>
    </div>
</aside>