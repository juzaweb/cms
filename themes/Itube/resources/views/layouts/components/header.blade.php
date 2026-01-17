<!-- ========== HEADER ========== -->
<header id="header" class="header left-aligned-navbar"
        data-hs-header-options='{
            "fixMoment": 1000,
            "fixEffect": "slide"
        }'>
    <div class="header-section shadow-soft">
        <div id="logoAndNav" class="container-fluid px-md-5">
            <!-- Nav -->
            <nav class="js-mega-menu navbar navbar-expand-xl py-0 position-static justify-content-start">
                <!-- Responsive Toggle Button -->
                <button type="button" class="navbar-toggler btn btn-icon btn-sm rounded-circle mr-2"
                        aria-label="Toggle navigation"
                        aria-expanded="false"
                        aria-controls="navBar"
                        data-toggle="collapse"
                        data-target="#navBar">
                        <span class="navbar-toggler-default">
                            <svg width="14" height="14" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                <path fill="currentColor" d="M17.4,6.2H0.6C0.3,6.2,0,5.9,0,5.5V4.1c0-0.4,0.3-0.7,0.6-0.7h16.9c0.3,0,0.6,0.3,0.6,0.7v1.4C18,5.9,17.7,6.2,17.4,6.2z M17.4,14.1H0.6c-0.3,0-0.6-0.3-0.6-0.7V12c0-0.4,0.3-0.7,0.6-0.7h16.9c0.3,0,0.6,0.3,0.6,0.7v1.4C18,13.7,17.7,14.1,17.4,14.1z"/>
                            </svg>
                        </span>
                    <span class="navbar-toggler-toggled">
                            <svg width="14" height="14" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                <path fill="currentColor" d="M11.5,9.5l5-5c0.2-0.2,0.2-0.6-0.1-0.9l-1-1c-0.3-0.3-0.7-0.3-0.9-0.1l-5,5l-5-5C4.3,2.3,3.9,2.4,3.6,2.6l-1,1 C2.4,3.9,2.3,4.3,2.5,4.5l5,5l-5,5c-0.2,0.2-0.2,0.6,0.1,0.9l1,1c0.3,0.3,0.7,0.3,0.9,0.1l5-5l5,5c0.2,0.2,0.6,0.2,0.9-0.1l1-1 c0.3-0.3,0.3-0.7,0.1-0.9L11.5,9.5z"/>
                            </svg>
                        </span>
                </button>
                <!-- End Responsive Toggle Button -->

                <!-- Logo -->
                <a class="navbar-brand w-auto mr-xl-5 mr-wd-8" href="{{ url('/') }}" aria-label="{{ setting('sitename') ?? setting('title') }}">
                    <img src="{{ logo_url() }}" alt="{{ setting('sitename') ?? setting('title') }}" class="default-logo" style="height: 40px;">
                </a>
                <!-- End Logo -->

                <div class="d-flex align-items-center ml-auto">
                    <form action="{{ home_url('search') }}" class="d-none d-xl-block mx-auto search-wrapper">
                        <label class="sr-only">Search</label>
                        <div class="input-group">
                            <input type="text" class="search-form-control form-control py-2 pl-4 min-width-250 rounded-pill" name="q" id="searchproduct-item" placeholder="{{ __('itube::translation.search') }}" aria-label="{{ __('itube::translation.search') }}" aria-describedby="searchProduct1" required value="{{ request('q') }}">
                            <div class="input-group-append position-absolute top-0 bottom-0 right-0  z-index-4">
                                <button class="d-flex py-2 px-3 border-0 bg-transparent align-items-center" type="submit" id="searchProduct1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" style="fill: #656565;">
                                        <path d="M7 0C11-0.1 13.4 2.1 14.6 4.9 15.5 7.1 14.9 9.8 13.9 11.4 13.7 11.7 13.6 12 13.3 12.2 13.4 12.5 14.2 13.1 14.4 13.4 15.4 14.3 16.3 15.2 17.2 16.1 17.5 16.4 18.2 16.9 18 17.5 17.9 17.6 17.9 17.7 17.8 17.8 17.2 18.3 16.7 17.8 16.4 17.4 15.4 16.4 14.3 15.4 13.3 14.3 13 14.1 12.8 13.8 12.5 13.6 12.4 13.5 12.3 13.3 12.2 13.3 12 13.4 11.5 13.8 11.3 14 10.7 14.4 9.9 14.6 9.2 14.8 8.9 14.9 8.6 14.9 8.3 14.9 8 15 7.4 15.1 7.1 15 6.3 14.8 5.6 14.8 4.9 14.5 2.7 13.6 1.1 12.1 0.4 9.7 0 8.7-0.2 7.1 0.2 6 0.3 5.3 0.5 4.6 0.9 4 1.8 2.4 3 1.3 4.7 0.5 5.2 0.3 5.7 0.2 6.3 0.1 6.5 0 6.8 0.1 7 0ZM7.3 1.5C7.1 1.6 6.8 1.5 6.7 1.5 6.2 1.6 5.8 1.7 5.4 1.9 3.7 2.5 2.6 3.7 1.9 5.4 1.7 5.8 1.7 6.2 1.6 6.6 1.4 7.4 1.6 8.5 1.8 9.1 2.4 11.1 3.5 12.3 5.3 13 5.9 13.3 6.6 13.5 7.5 13.5 7.7 13.5 7.9 13.5 8.1 13.5 8.6 13.4 9.1 13.3 9.6 13.1 11.2 12.5 12.4 11.4 13.1 9.8 13.6 8.5 13.6 6.6 13.1 5.3 12.2 3.1 10.4 1.5 7.3 1.5Z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="d-inline-flex ml-md-5">
                        <ul class="d-flex list-unstyled mb-0 align-items-center">
                            <li class="col d-xl-none position-static px-2">
                                <!-- Search -->
                                <div class="hs-unfold mr-2 position-static">
                                    <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary" href="javascript:;"
                                       data-hs-unfold-options='{
                                                "target": "#searchClassic",
                                                "type": "css-animation",
                                                "animationIn": "slideInUp"
                                            }'>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18">
                                            <path d="M7 0C11-0.1 13.4 2.1 14.6 4.9 15.5 7.1 14.9 9.8 13.9 11.4 13.7 11.7 13.6 12 13.3 12.2 13.4 12.5 14.2 13.1 14.4 13.4 15.4 14.3 16.3 15.2 17.2 16.1 17.5 16.4 18.2 16.9 18 17.5 17.9 17.6 17.9 17.7 17.8 17.8 17.2 18.3 16.7 17.8 16.4 17.4 15.4 16.4 14.3 15.4 13.3 14.3 13 14.1 12.8 13.8 12.5 13.6 12.4 13.5 12.3 13.3 12.2 13.3 12 13.4 11.5 13.8 11.3 14 10.7 14.4 9.9 14.6 9.2 14.8 8.9 14.9 8.6 14.9 8.3 14.9 8 15 7.4 15.1 7.1 15 6.3 14.8 5.6 14.8 4.9 14.5 2.7 13.6 1.1 12.1 0.4 9.7 0 8.7-0.2 7.1 0.2 6 0.3 5.3 0.5 4.6 0.9 4 1.8 2.4 3 1.3 4.7 0.5 5.2 0.3 5.7 0.2 6.3 0.1 6.5 0 6.8 0.1 7 0ZM7.3 1.5C7.1 1.6 6.8 1.5 6.7 1.5 6.2 1.6 5.8 1.7 5.4 1.9 3.7 2.5 2.6 3.7 1.9 5.4 1.7 5.8 1.7 6.2 1.6 6.6 1.4 7.4 1.6 8.5 1.8 9.1 2.4 11.1 3.5 12.3 5.3 13 5.9 13.3 6.6 13.5 7.5 13.5 7.7 13.5 7.9 13.5 8.1 13.5 8.6 13.4 9.1 13.3 9.6 13.1 11.2 12.5 12.4 11.4 13.1 9.8 13.6 8.5 13.6 6.6 13.1 5.3 12.2 3.1 10.4 1.5 7.3 1.5Z"></path>
                                        </svg>
                                    </a>

                                    <div id="searchClassic" class="hs-unfold-content dropdown-menu w-100 border-0 rounded-0 px-3 mt-0 right-0 left-0 mt-n2">
                                        <form action="{{ home_url('search') }}" class="input-group input-group-sm input-group-merge">
                                            <input type="text" class="form-control search-form-control rounded-pill" placeholder="{{ __('itube::translation.search') }}" aria-label="{{ __('itube::translation.search') }}" name="q">
                                            <div class="input-group-append">
                                                <button type="button" class="btn">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- End Search -->
                            </li>
                            {{--<li class="col pl-0 d-none d-xl-block">
                                <a @if(auth()->guest()) href="javascript:;" data-toggle="modal" data-target="#loginModal" @else href="{{ url('import') }}" @endif class="d-flex align-items-center text-dark" data-placement="top" title="" data-original-title="Uplode">
                                    <i class="fas fa-cloud-upload-alt" style="font-size: 25px;"></i>
                                    <span class="ml-2 text-dark">{{ __('itube::translation.upload') }}</span>
                                </a>
                            </li>--}}

                            {{--<li class="col pl-0 d-none d-xl-block">
                                <a @if(auth()->guest()) href="javascript:;" data-toggle="modal" data-target="#loginModal" @else href="{{ url('import') }}" @endif class="d-flex align-items-center text-dark" data-placement="top" title="" data-original-title="Download">
                                    <i class="fas fa-cloud-download-alt" style="font-size: 25px;"></i>
                                    <span class="ml-2 text-dark">@lang('Import')</span>
                                </a>
                            </li>--}}

                            @include('itube::components.language-selector')

                            <li class="col pr-xl-0 px-2 px-sm-3">
                                <!-- Unfold (Dropdown) -->
                                <div class="hs-unfold">
                                    <a class="js-hs-unfold-invoker dropdown-nav-link dropdown-toggle py-4 position-relative d-flex align-items-center" href="javascript:;"
                                       data-hs-unfold-options='{
                                                "target": "#basicDropdownHover",
                                                "type": "css-animation",
                                                "event": "click"
                                            }'>
                                        <img width="32" height="32"
                                             src="https://1.gravatar.com/avatar/7162c5aa667c497c4d1b90b36c60eaea?s=32&#038;d=mm&#038;r=g"
                                             class="rounded-circle"
                                             alt="User Avatar"
                                        />
                                    </a>

                                    <div id="basicDropdownHover" class="hs-unfold-content dropdown-menu my-account-dropdown">
                                        @auth
                                            <a class="dropdown-item" href="{{ home_url('profile') }}">
                                                <i class="fas fa-user"></i> @lang('Profile')</a>

                                            {{--<a class="dropdown-item" href="{{ home_url('profile/my-videos') }}">
                                                <i class="fas fa-video"></i> @lang('My Videos')</a>--}}

                                            <a class="dropdown-item" href="javascript:void(0)"
                                               onclick="$('.form-logout').submit()">
                                                <i class="fas fa-sign-out-alt"></i> @lang('Logout')
                                            </a>
                                        @else
                                            <!-- Modal Trigger -->
                                            <a class="dropdown-item" href="javascript:;"
                                               data-toggle="modal"
                                               data-target="#loginModal"><i class="fas fa-sign-in-alt"></i> {{ __('itube::translation.sign_in') }}</a>
                                            <a class="dropdown-item"
                                               href="javascript:;"
                                               data-toggle="modal"
                                               data-target="#loginModal">
                                                <i class="fas fa-user-plus"></i> @lang('Register')</a>
                                            <!-- End Modal Trigger -->
                                        @endauth

                                    </div>
                                </div>
                                <!-- End Unfold (Dropdown) -->
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Nav -->
        </div>
    </div>
</header>
<!-- ========== END HEADER ========== -->
