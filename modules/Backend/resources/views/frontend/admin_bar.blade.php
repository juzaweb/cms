<link rel="stylesheet" href="{{ asset("jw-styles/juzaweb/css/admin-bar.css") }}?v={{ \Juzaweb\CMS\Version::getVersion() }}">

<div id="jw-adminbar">
    <div id="jwadminbar" class="nojq nojs">
        <div class="quicklinks" id="wp-toolbar" role="navigation" aria-label="Toolbar">
            <ul id="wp-admin-bar-root-default" class="ab-top-menu">
                <li id="wp-admin-bar-wp-logo" class="menupop">
                    <a class="ab-item" aria-haspopup="true">
                        JuzaWeb
                        <span class="screen-reader-text">About JuzaWeb</span>
                    </a>

                    <div class="ab-sub-wrapper">
                        <ul id="wp-admin-bar-wp-logo-default" class="ab-submenu">
                            <li id="wp-admin-bar-about">
                                <a class="ab-item" href="">About JuzaWeb</a>
                            </li>
                        </ul>

                        <ul id="wp-admin-bar-wp-logo-external" class="ab-sub-secondary ab-submenu">
                            <li id="wp-admin-bar-wporg">
                                <a class="ab-item" href="https://juzaweb.com" target="_blank">JuzaWeb.com</a>
                            </li>
                            <li id="wp-admin-bar-documentation">
                                <a class="ab-item" href="https://juzaweb.com/docs" target="_blank">Documentation</a>
                            </li>
                            <li id="wp-admin-bar-support-forums">
                                <a class="ab-item" href="https://juzaweb.com/support" target="_blank">Support</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li id="wp-admin-bar-my-sites" class="menupop">
                    <a class="ab-item" aria-haspopup="true" href="">{{ trans('cms::app.my_sites') }}</a>
                    <div class="ab-sub-wrapper">
                        <ul id="wp-admin-bar-blog-1-default" class="ab-submenu">
                            <li id="wp-admin-bar-blog-1-d"><a class="ab-item" href="{{ admin_url() }}" data-turbolinks="false">{{ trans('cms::app.dashboard') }}</a>
                            </li>
                            <li id="wp-admin-bar-blog-1-n"><a class="ab-item" href="{{ admin_url('post-type/posts/create') }}" data-turbolinks="false">{{ trans('cms::app.new_post') }}</a></li>
                            <li id="wp-admin-bar-blog-1-c"><a class="ab-item" href="{{ admin_url('post-type/post/comments') }}" data-turbolinks="false">{{ trans('cms::app.manage_comments') }}</a></li>
                        </ul>
                    </div>
                </li>

                <li id="wp-admin-bar-new-content" class="menupop">
                    <a class="ab-item" aria-haspopup="true" href="">
                        <span class="ab-label">{{ trans('cms::app.new') }}</span>
                    </a>

                    <div class="ab-sub-wrapper">
                        <ul id="wp-admin-bar-new-content-default" class="ab-submenu">
                            <li id="wp-admin-bar-new-post"><a class="ab-item" href="{{ admin_url('post-type/posts/create') }}" data-turbolinks="false">{{ trans('cms::app.post') }}</a>
                            </li>

                            <li id="wp-admin-bar-new-page"><a class="ab-item" href="{{ admin_url('post-type/pages/create') }}" data-turbolinks="false">{{ trans('cms::app.page') }}</a>
                            </li>

                            <li id="wp-admin-bar-new-user"><a class="ab-item" href="{{ admin_url('users/create') }}" data-turbolinks="false">{{ trans('cms::app.user') }}</a>
                            </li>
                        </ul>
                    </div>
                </li>

                @if(isset($post))
                <li id="wp-admin-bar-edit">
                    <a class="ab-item" href="">Edit Post</a>
                </li>
                @endif
            </ul>

            <ul id="wp-admin-bar-top-secondary" class="ab-top-secondary ab-top-menu">
                {{--<li id="wp-admin-bar-search" class="admin-bar-search">
                    <div class="ab-item ab-empty-item" tabindex="-1">
                        <form action="" method="get" id="adminbarsearch">
                            <input class="adminbar-input" name="s" id="adminbar-search" type="text" value=""
                                    maxlength="150"/><label for="adminbar-search"
                                                            class="screen-reader-text">Search</label><input type="submit"
                                                                                                            class="adminbar-button"
                                                                                                            value="Search"/>
                        </form>
                    </div>
                </li>--}}
                <li id="wp-admin-bar-my-account"
                    class="menupop with-avatar">
                    <a class="ab-item" aria-haspopup="true" href="">
                        {{ trans('cms::app.howdy') }}, <span class="display-name">{{ $user['name'] }}</span>
                        <img alt=""
                             src="{{ $user['avatar'] }}"
                             srcset="{{ $user['avatar'] }}"
                             class="avatar avatar-26 photo"
                             height="26"
                             width="26"
                             loading="lazy" />
                    </a>

                    <div class="ab-sub-wrapper">
                        <ul id="wp-admin-bar-user-actions" class="ab-submenu">
                            <li id="wp-admin-bar-user-info">
                                <a class="ab-item"
                                   tabindex="-1"
                                   href=""
                                   data-turbolinks="false"
                                >

                                    <img alt=""
                                         src="{{ $user['avatar'] }}"
                                         srcset="{{ $user['avatar'] }}"
                                         class="avatar avatar-64 photo"
                                         height="64"
                                         width="64"
                                         loading="lazy"
                                    />
                                    <span class="display-name">{{ $user['name'] }}</span>
                                </a>
                            </li>

                            <li id="wp-admin-bar-logout">
                                <a class="ab-item" href="javascript:void(0)" onclick="document.getElementsByClassName('form-logout')[0].submit()">
                                    {{ trans('cms::app.logout') }}
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
