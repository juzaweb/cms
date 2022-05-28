import React, {useEffect} from 'react'
import {usePage, Link} from '@inertiajs/inertia-react'
import {Page, PageProps} from "@inertiajs/inertia";

interface MenuTopPageProps extends Page<PageProps> {
    props: {
        auth: any;
        juzaweb: any;
        errors: any;
        adminPrefix: string
    }
}

export default function MenuTop() {
    const {auth, juzaweb, adminPrefix} = usePage<MenuTopPageProps>().props

    return (
        <div className="juzaweb__topbar">
            <div className="mr-4">
                <a href="/" className="mr-2" rel="noopener noreferrer" target="_blank">
                    <i className="dropdown-toggle-icon fa fa-home"
                       title={juzaweb?.lang?.view_site}></i> {juzaweb?.lang?.view_site}
                </a>
            </div>

            <div className="mr-auto">
                <div className="dropdown mr-4 d-none d-sm-block">
                    <Link href="#" className="dropdown-toggle text-nowrap" data-toggle="dropdown">
                        <i className="fa fa-plus"></i>
                        <span className="dropdown-toggle-text"> New</span>
                    </Link>

                    <div className="dropdown-menu" role="menu">
                        <a className="dropdown-item" href="">Post</a>

                        <a className="dropdown-item" href="">Page</a>

                        <a className="dropdown-item" href="">User</a>
                    </div>
                </div>
            </div>

            {/* @do_action('backend.menu_top') */}

            <div className="juzaweb__topbar__actionsDropdown dropdown mr-4 d-none d-sm-block">
                <a href="" className="dropdown-toggle text-nowrap" data-toggle="dropdown" aria-expanded="false"
                   data-offset="0,15">
                    <i className="dropdown-toggle-icon fa fa-bell-o"></i> <span>{auth?.user.totalNotifications}</span>
                </a>

                <div className="juzaweb__topbar__actionsDropdownMenu dropdown-menu dropdown-menu-right" role="menu">
                    <div style={{width: "350px"}}>
                        <div className="card-body">
                            <div className="tab-content">
                                <div className="jw__l1">
                                    <div
                                        className="text-uppercase mb-2 text-gray-6 mb-2 font-weight-bold">Notifications ({auth?.user.totalNotifications})
                                    </div>
                                    <hr/>
                                    <ul className="list-unstyled">
                                        {
                                            auth?.user.notifications.map(
                                                (item, index) => {
                                                    return (
                                                        <li key={index} className="jw__l8__item">
                                                            <a href={ item.data?.url }
                                                               className="jw__l8__itemLink">
                                                                <div className="jw__l8__itemPic bg-success">

                                                                </div>
                                                                <div>
                                                                    <div
                                                                        className="text-blue">{item.data?.subject}</div>
                                                                    <div
                                                                        className="text-muted">{item.created_at}</div>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    )
                                                }
                                            )
                                        }
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div className="dropdown">
                <a href=""
                   className="dropdown-toggle text-nowrap"
                   data-toggle="dropdown"
                   aria-expanded="false"
                   data-offset="5,15"
                >
                    <img
                        className="dropdown-toggle-avatar"
                        src={auth?.user.avatar}
                        alt="User avatar"
                        width="30"
                        height="30"
                    />
                </a>

                <div className="dropdown-menu dropdown-menu-right" role="menu">
                    <Link className="dropdown-item" href={'/' + adminPrefix + '/users/' + auth?.user.id + '/edit'}>
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
