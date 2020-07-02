<!DOCTYPE html>
<html lang="en" data-kit-theme="default">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <link rel="icon" type="image/png" href="../../components/kit-core/img/favicon.png" />
    <link href="https://fonts.googleapis.com/css?family=Mukta:400,700,800&display=swap" rel="stylesheet">

    <!-- VENDORS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/backend.css') }}">

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/backend.js') }}"></script>

</head>

<body class="cui__layout--cardsShadow cui__menuLeft--dark">
<div class="cui__layout cui__layout--hasSider">


    <div class="cui__sidebar kit__customScroll">
        <div class="cui__sidebar__inner">
            <a
                    href="javascript: void(0);"
                    class="cui__sidebar__close cui__sidebar__actionToggle fe fe-x-circle"
            ></a>
            <h5>
                <strong>Theme Settings</strong>
            </h5>
            <div class="cui__utils__line" style="margin-top: 25px; margin-bottom: 30px"></div>
            <div class="cui__sidebar__type">
                <div class="cui__sidebar__type__title">
                    <span>Application Name</span>
                </div>
                <div class="cui__sidebar__type__items">
                    <input id="appName" class="form-control" value="Clean UI Pro" />
                </div>
            </div>
            <div class="cui__sidebar__item hideIfMenuTop">
                <div class="cui__sidebar__label">
                    Left Menu: Collapsed
                </div>
                <div class="cui__sidebar__container">
                    <label class="cui__sidebar__switch">
                        <input type="checkbox" to="body" setting="cui__menuLeft--toggled" />
                        <span class="cui__sidebar__switch__slider"></span>
                    </label>
                </div>
            </div>
            <div class="cui__sidebar__item hideIfMenuTop">
                <div class="cui__sidebar__label">
                    Left Menu: Unfixed
                </div>
                <div class="cui__sidebar__container">
                    <label class="cui__sidebar__switch">
                        <input type="checkbox" to="body" setting="cui__menuLeft--unfixed" />
                        <span class="cui__sidebar__switch__slider"></span>
                    </label>
                </div>
            </div>
            <div class="cui__sidebar__item hideIfMenuTop">
                <div class="cui__sidebar__label">
                    Left Menu: Shadow
                </div>
                <div class="cui__sidebar__container">
                    <label class="cui__sidebar__switch">
                        <input type="checkbox" to="body" setting="cui__menuLeft--shadow" />
                        <span class="cui__sidebar__switch__slider"></span>
                    </label>
                </div>
            </div>
            <div class="cui__sidebar__item">
                <div class="cui__sidebar__label">
                    Menu: Color
                </div>
                <div class="cui__sidebar__container">
                    <div class="cui__sidebar__select" to="body">
                        <div
                                class="cui__sidebar__select__item cui__sidebar__select__item--white cui__sidebar__select__item--active"
                        ></div>
                        <div
                                class="cui__sidebar__select__item cui__sidebar__select__item--gray"
                                setting="cui__menuLeft--gray cui__menuTop--gray"
                        ></div>
                        <div
                                class="cui__sidebar__select__item cui__sidebar__select__item--black"
                                setting="cui__menuLeft--dark cui__menuTop--dark"
                        ></div>
                    </div>
                </div>
            </div>
            <div class="cui__sidebar__item">
                <div class="cui__sidebar__label">
                    Auth: Background
                </div>
                <div class="cui__sidebar__container">
                    <div class="cui__sidebar__select" to="body">
                        <div
                                class="cui__sidebar__select__item cui__sidebar__select__item--white cui__sidebar__select__item--active"
                        ></div>
                        <div
                                class="cui__sidebar__select__item cui__sidebar__select__item--gray"
                                setting="cui__auth--gray"
                        ></div>
                        <div
                                class="cui__sidebar__select__item cui__sidebar__select__item--img"
                                setting="cui__auth--img"
                        ></div>
                    </div>
                </div>
            </div>
            <div class="cui__sidebar__item">
                <div class="cui__sidebar__label">
                    Topbar: Fixed
                </div>
                <div class="cui__sidebar__container">
                    <label class="cui__sidebar__switch">
                        <input type="checkbox" to="body" setting="cui__topbar--fixed" />
                        <span class="cui__sidebar__switch__slider"></span>
                    </label>
                </div>
            </div>
            <div class="cui__sidebar__item">
                <div class="cui__sidebar__label">
                    Topbar: Gray Background
                </div>
                <div class="cui__sidebar__container">
                    <label class="cui__sidebar__switch">
                        <input type="checkbox" to="body" setting="cui__topbar--gray" />
                        <span class="cui__sidebar__switch__slider"></span>
                    </label>
                </div>
            </div>
            <div class="cui__sidebar__item">
                <div class="cui__sidebar__label">
                    App: Content Max-Width
                </div>
                <div class="cui__sidebar__container">
                    <label class="cui__sidebar__switch">
                        <input type="checkbox" to="body" setting="cui__layout--contentMaxWidth" />
                        <span class="cui__sidebar__switch__slider"></span>
                    </label>
                </div>
            </div>
            <div class="cui__sidebar__item">
                <div class="cui__sidebar__label">
                    App: Max-Width
                </div>
                <div class="cui__sidebar__container">
                    <label class="cui__sidebar__switch">
                        <input type="checkbox" to="body" setting="cui__layout--appMaxWidth" />
                        <span class="cui__sidebar__switch__slider"></span>
                    </label>
                </div>
            </div>
            <div class="cui__sidebar__item">
                <div class="cui__sidebar__label">
                    App: Gray background
                </div>
                <div class="cui__sidebar__container">
                    <label class="cui__sidebar__switch">
                        <input type="checkbox" to="body" setting="cui__layout--grayBackground" />
                        <span class="cui__sidebar__switch__slider"></span>
                    </label>
                </div>
            </div>
            <div class="cui__sidebar__item">
                <div class="cui__sidebar__label">
                    Cards: Squared Borders
                </div>
                <div class="cui__sidebar__container">
                    <label class="cui__sidebar__switch">
                        <input type="checkbox" to="body" setting="cui__layout--squaredBorders" />
                        <span class="cui__sidebar__switch__slider"></span>
                    </label>
                </div>
            </div>
            <div class="cui__sidebar__item">
                <div class="cui__sidebar__label">
                    Cards: Shadow
                </div>
                <div class="cui__sidebar__container">
                    <label class="cui__sidebar__switch">
                        <input type="checkbox" to="body" setting="cui__layout--cardsShadow" />
                        <span class="cui__sidebar__switch__slider"></span>
                    </label>
                </div>
            </div>
            <div class="cui__sidebar__item">
                <div class="cui__sidebar__label">
                    Cards: Borderless
                </div>
                <div class="cui__sidebar__container">
                    <label class="cui__sidebar__switch">
                        <input type="checkbox" to="body" setting="cui__layout--borderless" />
                        <span class="cui__sidebar__switch__slider"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>


    <div class="cui__menuLeft">
        <div class="cui__menuLeft__mobileTrigger"><span></span></div>
        <div class="cui__menuLeft__trigger"></div>
        <div class="cui__menuLeft__outer">
            <div class="cui__menuLeft__logo__container">
                <div class="cui__menuLeft__logo">
                    <img src="https://html.cleanui.cloud/components/kit/core/img/logo.svg" class="mr-2" alt="Clean UI" />
                    <div class="cui__menuLeft__logo__name">Clean UI Pro</div>
                    <div class="cui__menuLeft__logo__descr">Html</div>
                </div>
            </div>
            <div class="cui__menuLeft__scroll kit__customScroll">
                @include('backend.menu')

            </div>
        </div>
    </div>
    <div class="cui__menuLeft__backdrop"></div>

    <div class="cui__layout">
        <div class="cui__layout__header">
            <div class="cui__topbar">
                <div class="mr-4">
                    <a href="javascript: void(0);" class="mr-2">
                        <i class="dropdown-toggle-icon fe fe-home" data-toggle="tooltip" data-placement="bottom"
                           title="Dashboard Alpha"></i>
                    </a>
                    <a href="javascript: void(0);" class="mr-2">
                        <i class="dropdown-toggle-icon fe fe-home" data-toggle="tooltip" data-placement="bottom"
                           title="Dashboard Beta"></i>
                    </a>
                    <span class="dropdown">
      <a href="" class="dropdown-toggle text-nowrap" data-toggle="dropdown" aria-expanded="false" data-offset="0,15">
        <i class="dropdown-toggle-icon fe fe-star" data-toggle="tooltip" data-placement="bottom" title="Bookmarks"></i>
      </a>
      <div class="dropdown-menu" role="menu">
        <div class="card-body p-1 cui__topbar__favs">
          <div class="px-2 pb-2 pt-0">
            <input class="form-control" type="text" placeholder="Find pages..." />
          </div>
          <div class="kit__customScroll height-200">
            <div class="px-2 pb-2">
              <a href="./dashboards-alpha.html" class="cui__topbar__favs__link">
                <div class="cui__topbar__favs__setIcon cui__topbar__favs__setIconActive">
                  <i class="fe fe-star"></i>
                </div>
                <span>
                  <i class="mr-2 fe fe-home"></i>
                  Dashboard Alpha
                </span>
              </a>
              <a href="./dashboards-beta.html" class="cui__topbar__favs__link">
                <div class="cui__topbar__favs__setIcon cui__topbar__favs__setIconActive">
                  <i class="fe fe-star"></i>
                </div>
                <span>
                  <i class="mr-2 fe fe-home"></i>
                  Dashboard Beta
                </span>
              </a>
              <a href="./dashboards-gamma.html" class="cui__topbar__favs__link">
                <div class="cui__topbar__favs__setIcon">
                  <i class="fe fe-star"></i>
                </div>
                <span>
                  <i class="mr-2 fe fe-home"></i>
                  Dashboard Gamma
                </span>
              </a>
              <a href="./dashboards-crypto.html" class="cui__topbar__favs__link">
                <div class="cui__topbar__favs__setIcon">
                  <i class="fe fe-star"></i>
                </div>
                <span>
                  <i class="mr-2 fe fe-home"></i>
                  Dashboard Crypto
                </span>
              </a>
              <a href="./apps-profile.html" class="cui__topbar__favs__link">
                <div class="cui__topbar__favs__setIcon">
                  <i class="fe fe-star"></i>
                </div>
                <span>
                  <i class="mr-2 fe fe-database"></i>
                  Profile
                </span>
              </a>
              <a href="./apps-calendar.html" class="cui__topbar__favs__link">
                <div class="cui__topbar__favs__setIcon">
                  <i class="fe fe-star"></i>
                </div>
                <span>
                  <i class="mr-2 fe fe-database"></i>
                  Calendar
                </span>
              </a>
              <a href="./apps-gallery.html" class="cui__topbar__favs__link">
                <div class="cui__topbar__favs__setIcon">
                  <i class="fe fe-star"></i>
                </div>
                <span>
                  <i class="mr-2 fe fe-database"></i>
                  Gallery
                </span>
              </a>
              <a href="./apps-messaging.html" class="cui__topbar__favs__link">
                <div class="cui__topbar__favs__setIcon">
                  <i class="fe fe-star"></i>
                </div>
                <span>
                  <i class="mr-2 fe fe-database"></i>
                  Messaging
                </span>
              </a>
              <a href="./apps-mail.html" class="cui__topbar__favs__link">
                <div class="cui__topbar__favs__setIcon">
                  <i class="fe fe-star"></i>
                </div>
                <span>
                  <i class="mr-2 fe fe-database"></i>
                  Mail
                </span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </span>
                </div>
                <div class="mr-auto">
                    <div class="cui__topbar__search">
                        <i class="fe fe-search">
                            <!-- --></i>
                        <input type="text" id="livesearch__input" placeholder="Type to search..." />
                    </div>
                    <div class="cui__topbar__livesearch">
                        <button class="cui__topbar__livesearch__close" type="button">
                            <i class="icmn-cross"></i>
                        </button>
                        <div class="container-fluid">
                            <div class="cui__topbar__livesearch__wrapper">
                                <input type="text" id="livesearch__input__inner" class="cui__topbar__livesearch__input"
                                       placeholder="Type to search..." />
                                <ul class="cui__topbar__livesearch__options">
                                    <li class="cui__topbar__livesearch__option">
                                        <label class="kit__utils__control kit__utils__control__checkbox">
                                            <input type="checkbox" checked="checked" />
                                            <span class="kit__utils__control__indicator"></span>
                                            Search within page
                                        </label>
                                    </li>
                                    <li class="cui__topbar__livesearch__option">Press enter to search</li>
                                </ul>
                                <div class="cui__topbar__livesearch__results">
                                    <div class="cui__topbar__livesearch__results__title">
                                        <span>Pages Search Results</span>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="cui__topbar__livesearch__result__content">
                                                <div class="cui__topbar__livesearch__result__thumb"
                                                     style="background-image: url('{{ asset('styles/components/kit-core/img/content/photos/1.jpeg') }}')">
                                                    #1
                                                </div>
                                                <div class="cui__topbar__livesearch__result">
                                                    <div class="cui__topbar__livesearch__result__text">
                                                        Samsung Galaxy A50 4GB/64GB
                                                    </div>
                                                    <div class="cui__topbar__livesearch__result__source">In some partition</div>
                                                </div>
                                            </div>
                                            <div class="cui__topbar__livesearch__result__content">
                                                <div class="cui__topbar__livesearch__result__thumb"
                                                     style="background-image: url('{{ asset('styles/components/kit-core/img/content/photos/2.jpeg') }}')">
                                                    KF
                                                </div>
                                                <div class="cui__topbar__livesearch__result">
                                                    <div class="cui__topbar__livesearch__result__text">
                                                        Apple iPhone 11 64GB
                                                    </div>
                                                    <div class="cui__topbar__livesearch__result__source">In some partition</div>
                                                </div>
                                            </div>
                                            <div class="cui__topbar__livesearch__result__content">
                                                <div class="cui__topbar__livesearch__result__thumb"
                                                     style="background-image: url('{{ asset('styles/components/kit-core/img/content/photos/3.jpeg') }}')">
                                                    GF
                                                </div>
                                                <div class="cui__topbar__livesearch__result">
                                                    <div class="cui__topbar__livesearch__result__text">
                                                        Samsung Galaxy A51 SM-A515F/DS 4GB/64GB
                                                    </div>
                                                    <div class="cui__topbar__livesearch__result__source">In some partition</div>
                                                </div>
                                            </div>
                                            <div class="cui__topbar__livesearch__result__content">
                                                <div class="cui__topbar__livesearch__result__thumb"
                                                     style="background-image: url('{{ asset('styles/components/kit-core/img/content/photos/4.jpeg') }}')">
                                                    GF
                                                </div>
                                                <div class="cui__topbar__livesearch__result">
                                                    <div class="cui__topbar__livesearch__result__text">
                                                        Xiaomi Redmi 8 4GB/64GB
                                                    </div>
                                                    <div class="cui__topbar__livesearch__result__source">In some partition</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="cui__topbar__livesearch__result__content">
                                                <div class="cui__topbar__livesearch__result__thumb">01</div>
                                                <div class="cui__topbar__livesearch__result">
                                                    <div class="cui__topbar__livesearch__result__text">
                                                        White Case
                                                    </div>
                                                    <div class="cui__topbar__livesearch__result__source">In some partition</div>
                                                </div>
                                            </div>
                                            <div class="cui__topbar__livesearch__result__content">
                                                <div class="cui__topbar__livesearch__result__thumb">02</div>
                                                <div class="cui__topbar__livesearch__result">
                                                    <div class="cui__topbar__livesearch__result__text">
                                                        Blue Case
                                                    </div>
                                                    <div class="cui__topbar__livesearch__result__source">In some partition</div>
                                                </div>
                                            </div>
                                            <div class="cui__topbar__livesearch__result__content">
                                                <div class="cui__topbar__livesearch__result__thumb">03</div>
                                                <div class="cui__topbar__livesearch__result">
                                                    <div class="cui__topbar__livesearch__result__text">
                                                        Green Case
                                                    </div>
                                                    <div class="cui__topbar__livesearch__result__source">In some partition</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dropdown mr-4 d-none d-md-block">
                    <a href="" class="dropdown-toggle text-nowrap" data-toggle="dropdown" aria-expanded="false" data-offset="0,15">
                        <i class="dropdown-toggle-icon fe fe-folder"></i>
                        <span class="dropdown-toggle-text d-none d-xl-inline">Issues History</span>
                    </a>
                    <div class="dropdown-menu" role="menu">
                        <a class="dropdown-item" href="javascript:void(0)">Current search</a>
                        <a class="dropdown-item" href="javascript:void(0)">Search for issues</a>
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-header">Opened</div>
                        <a class="dropdown-item" href="javascript:void(0)"><i class="fe fe-check-circle mr-2"></i> CLNUI-253 Project
                            implemen...
                        </a>
                        <a class="dropdown-item" href="javascript:void(0)"><i class="fe fe-check-circle mr-2"></i> CLNUI-234 Active
                            history iss...
                        </a>
                        <a class="dropdown-item" href="javascript:void(0)"><i class="fe fe-check-circle mr-2"></i> CLNUI-424 Ionicons
                            intergrat...
                        </a>
                        <a class="dropdown-item" href="javascript:void(0)">More...</a>
                        <div class="dropdown-header">Filters</div>
                        <a class="dropdown-item" href="javascript:void(0)">My open issues</a>
                        <a class="dropdown-item" href="javascript:void(0)">Reported by me</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="javascript:void(0)">
                            <i class="dropdown-icon fe fe-settings"></i>
                            Settings
                        </a>
                    </div>
                </div>
                <div class="dropdown mb-0 mr-auto d-xl-block d-none">
                    <a href="" class="dropdown-toggle text-nowrap" data-toggle="dropdown" aria-expanded="false" data-offset="0,15">
                        <i class="dropdown-toggle-icon fe fe-database"></i>
                        <span class="dropdown-toggle-text">Project Management</span>
                    </a>
                    <div class="dropdown-menu" role="menu">
                        <div class="dropdown-header">Active</div>
                        <a class="dropdown-item" href="javascript:void(0)">Project Management</a>
                        <a class="dropdown-item" href="javascript:void(0)">User Inetrface Development</a>
                        <a class="dropdown-item" href="javascript:void(0)">Documentation</a>
                        <div class="dropdown-header">Inactive</div>
                        <a class="dropdown-item" href="javascript:void(0)">Marketing</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="javascript:void(0)">
                            <i class="dropdown-icon fe fe-settings"></i>
                            Settings
                        </a>
                    </div>
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
                        <img class="dropdown-toggle-avatar" src="https://html.cleanui.cloud/components/kit/core/img/avatars/avatar-2.png" alt="User avatar" />
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                        <a class="dropdown-item" href="javascript:void(0)">
                            <i class="dropdown-icon fe fe-user"></i>
                            Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-header">
                            Home
                        </div>
                        <a class="dropdown-item" href="javascript:void(0)">
                            <i class="dropdown-icon fe fe-chevron-right"></i>
                            System Dashboard
                        </a>
                        <a class="dropdown-item" href="javascript:void(0)">
                            <i class="dropdown-icon fe fe-chevron-right"></i>
                            User Boards
                        </a>
                        <a class="dropdown-item" href="javascript:void(0)">
                            <i class="dropdown-icon fe fe-chevron-right"></i>
                            Issue Navigator
                            <span class="badge badge-success font-size-11 ml-2">25 New</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="javascript:void(0)">
                            <i class="dropdown-icon fe fe-log-out"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="cui__layout__content">
            @yield('content')
        </div>
        <div class="cui__layout__footer">
            <div class="cui__footer">
                <div class="cui__footer__inner">
                    <a
                            href="https://sellpixels.com"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="cui__footer__logo"
                    >
                        SELLPIXELS
                        <span></span>
                    </a>
                    <br />
                    <p class="mb-0">
                        Copyright © 2017-2020 Mdtk Soft |
                        <a href="https://www.mediatec.org/privacy" target="_blank" rel="noopener noreferrer">Privacy Policy</a>
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).on("turbolinks:load", function() {
        var myLazyLoad = new LazyLoad();

    });
</script>
<script type="text/javascript">
    $.extend( $.validator.messages, {
        required: "{{ trans('app.this_field_is_required') }}",
    } );

    $(".form-ajax").validate();
</script>
</body>
</html>