<div class="cui__topbar">
    <div class="mr-4">

    </div>
    <div class="mr-auto">
        <div class="cui__topbar__search">
            <i class="fe fe-search">
                <!-- --></i>
            <input type="text" placeholder="Type to search..." />
        </div>
    </div>

    <div class="mr-4 d-none d-md-block">
        <a href="{{ route('home') }}" data-turbolinks="false" target="_blank" class="text-nowrap">
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
            <a class="dropdown-item" href="javascript:void(0)"><span class="text-uppercase font-size-12 mr-1">FR</span>
                French</a>
            <a class="dropdown-item" href="javascript:void(0)"><span class="text-uppercase font-size-12 mr-1">RU</span>
                Русский</a>
            <a class="dropdown-item" href="javascript:void(0)"><span class="text-uppercase font-size-12 mr-1">CN</span>
                简体中文</a>
        </div>
    </div>
    <div class="cui__topbar__actionsDropdown dropdown mr-4 d-none d-sm-block">
        <a href="" class="dropdown-toggle text-nowrap" data-toggle="dropdown" aria-expanded="false" data-offset="0,15">
            <i class="dropdown-toggle-icon fe fe-bell"></i>
        </a>
        <div class="cui__topbar__actionsDropdownMenu dropdown-menu dropdown-menu-right" role="menu">
            <div style="width: 350px;">
                <div class="card-header card-header-flex">
                    <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-bold nav-tabs-noborder nav-tabs-stretched">
                        <li class="nav-item">
                            <a
                                    href="#tab-alert-content"
                                    class="nav-link active"
                                    id="tab-alert"
                                    role="button"
                                    data-toggle="tab"
                            >
                                Alerts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a
                                    href="#tab-events-content"
                                    class="nav-link"
                                    id="tab-events"
                                    role="button"
                                    data-toggle="tab"
                            >
                                Events
                            </a>
                        </li>
                        <li class="nav-item">
                            <a
                                    href="#tab-actions-content"
                                    class="nav-link"
                                    id="tab-actions"
                                    role="button"
                                    data-toggle="tab"
                            >
                                Actions
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div
                                class="tab-pane fade show active"
                                id="tab-alert-content"
                                role="tabpanel"
                                aria-labelledby="tab-alert-content"
                        >
                            <div class="height-300 kit__customScroll">
                                <ul class="list-unstyled">
                                    <li class="mb-3">
                                        <div class="d-flex align-items-baseline">
                                            <p class="kit__l2__title">
                                                Update Status:
                                                <strong class="text-black">New</strong>
                                            </p>
                                            <span class="kit__l2__span">5 min ago</span>
                                        </div>
                                        <p class="kit__l2__content text-muted">
                                            Mary has approved your quote.
                                        </p>
                                    </li>

                                    <li class="mb-3">
                                        <div class="d-flex align-items-baseline">
                                            <p class="kit__l2__title">
                                                Update Status:
                                                <strong class="text-danger">Rejected</strong>
                                            </p>
                                            <span class="kit__l2__span">15 min ago</span>
                                        </div>
                                        <p class="kit__l2__content text-muted">
                                            Mary has declined your quote.
                                        </p>
                                    </li>
                                    <li class="mb-3">
                                        <div class="d-flex align-items-baseline">
                                            <p class="kit__l2__title">
                                                Payment Received:
                                                <strong class="text-black">$5,467.00</strong>
                                            </p>
                                            <span class="kit__l2__span">15 min ago</span>
                                        </div>
                                        <p class="kit__l2__content text-muted">
                                            GOOGLE, LLC AUTOMATED PAYMENTS PAYMENT
                                        </p>
                                    </li>
                                    <li class="mb-3">
                                        <div class="d-flex align-items-baseline">
                                            <p class="kit__l2__title">
                                                Notification:
                                                <strong class="text-danger">Access Denied</strong>
                                            </p>
                                            <span class="kit__l2__span">5 Hours ago</span>
                                        </div>
                                        <p class="kit__l2__content text-muted">
                                            The system prevent login to your account
                                        </p>
                                    </li>
                                    <li class="mb-3">
                                        <div class="d-flex align-items-baseline">
                                            <p class="kit__l2__title">
                                                Payment Received:
                                                <strong class="text-black">$55,829.00</strong>
                                            </p>
                                            <span class="kit__l2__span">1 day ago</span>
                                        </div>
                                        <p class="kit__l2__content text-muted">
                                            GOOGLE, LLC AUTOMATED PAYMENTS PAYMENT
                                        </p>
                                    </li>
                                    <li class="mb-3">
                                        <div class="d-flex align-items-baseline">
                                            <p class="kit__l2__title">
                                                Notification:
                                                <strong class="text-danger">Access Denied</strong>
                                            </p>
                                            <span class="kit__l2__span">5 Hours ago</span>
                                        </div>
                                        <p class="kit__l2__content text-muted">
                                            The system prevent login to your account
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div
                                class="tab-pane fade"
                                id="tab-events-content"
                                role="tabpanel"
                                aria-labelledby="tab-alert-content"
                        >
                            <div class="text-center py-4 bg-light rounded">
                                No Events Today
                            </div>
                        </div>
                        <div
                                class="tab-pane fade"
                                id="tab-actions-content"
                                role="tabpanel"
                                aria-labelledby="tab-alert-content"
                        >
                            <div class="text-center py-4 bg-light rounded">
                                No Actions Today
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="dropdown">
        <a href="" class="dropdown-toggle text-nowrap" data-toggle="dropdown" aria-expanded="false" data-offset="5,15">
            <img class="dropdown-toggle-avatar" src="{{ asset('images/avatar-2.png') }}" alt="User avatar" />
        </a>
        <div class="dropdown-menu dropdown-menu-right" role="menu">
            <a class="dropdown-item" href="javascript:void(0)">
                <i class="dropdown-icon fe fe-user"></i>
                Profile
            </a>

            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="javascript:void(0)">
                <i class="dropdown-icon fe fe-log-out"></i> Logout
            </a>
        </div>
    </div>
</div>