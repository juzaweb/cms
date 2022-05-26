import React, { useEffect } from 'react'
import { usePage, Link } from '@inertiajs/inertia-react'

export default function MenuTop() {
    const { auth } = usePage().props

    return (
        <div className="juzaweb__topbar">
            <div className="mr-4">
                <a href="/" className="mr-2" target="_blank">
                    <i className="dropdown-toggle-icon fa fa-home" title={juzaweb.lang.view_site}></i> {juzaweb.lang.view_site}
                </a>
            </div>

            {/* <div className="mr-auto">
                <div className="dropdown mr-4 d-none d-sm-block">
                    <a href="javascript:void(0)" className="dropdown-toggle text-nowrap" data-toggle="dropdown">
                        <i className="fa fa-plus"></i>
                        <span className="dropdown-toggle-text"> {{ trans('cms::app.new') }}</span>
                    </a>

                    <div className="dropdown-menu" role="menu">
                        <a className="dropdown-item" href="{{ route('admin.posts.create', ['posts']) }}">{{ trans('cms::app.post') }}</a>

                        <a className="dropdown-item" href="{{ route('admin.posts.create', ['pages']) }}">{{ trans('cms::app.page') }}</a>

                        <a className="dropdown-item" href="{{ route('admin.users.create') }}">{{ trans('cms::app.user') }}</a>
                    </div>
                </div>
            </div> */}

            {/* @do_action('backend.menu_top') */}

            <div className="juzaweb__topbar__actionsDropdown dropdown mr-4 d-none d-sm-block">
                <a href="" className="dropdown-toggle text-nowrap" data-toggle="dropdown" aria-expanded="false" data-offset="0,15">
                    <i className="dropdown-toggle-icon fa fa-bell-o"></i>
                </a>

                {/* @php
                    $total = count_unread_notifications();

                    $items = Auth::user()
                        ->unreadNotifications()
                        ->orderBy('id', 'DESC')
                        ->limit(5)
                        ->get(['id', 'data', 'created_at']);
                @endphp */}

                <div className="juzaweb__topbar__actionsDropdownMenu dropdown-menu dropdown-menu-right" role="menu">
                    <div style={{width:"350px"}}>
                        <div className="card-body">
                            <div className="tab-content">
                                <div className="jw__l1">
                                    <div className="text-uppercase mb-2 text-gray-6 mb-2 font-weight-bold">Notifications</div>
                                    <hr />
                                    <ul className="list-unstyled">

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div className="dropdown">
                <a href="" className="dropdown-toggle text-nowrap" data-toggle="dropdown" aria-expanded="false" data-offset="5,15">
                    <img className="dropdown-toggle-avatar" src={auth.user.avatar} alt="User avatar" width="30" height="30"/>
                </a>

                <div className="dropdown-menu dropdown-menu-right" role="menu">
                    <Link className="dropdown-item" href="">
                        <i className="dropdown-icon fe fe-user"></i>
                        Profile
                    </Link>

                    <div className="dropdown-divider"></div>
                    <a href="" data-turbolinks="false" className="dropdown-item auth-logout">
                        <i className="dropdown-icon fe fe-log-out"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    )
}
