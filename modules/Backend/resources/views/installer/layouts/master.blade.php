<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('template_title')</title>

        <script src="{{ asset('jw-styles/juzaweb/js/jquery.min.js') }}"></script>
        <link href="{{ asset('jw-styles/juzaweb/installer/css/style.css') }}" rel="stylesheet"/>

        <script>
            window.Laravel = @json([
                'csrfToken' => csrf_token(),
            ])
        </script>

        @yield('style')
    </head>
    <body>
        <div class="master">
            <div class="box">
                <div class="header">
                    <h1 class="header__title">@yield('title')</h1>
                </div>

                <ul class="step">
                    <li class="step__divider"></li>
                    <li class="step__item {{ is_active_route('installer.final') }}">
                        <i class="step__icon fa fa-server" aria-hidden="true"></i>
                    </li>
                    <li class="step__divider"></li>
                    <li class="step__item {{ is_active_route('installer.admin') }}">
                        <i class="step__icon fa fa-user" aria-hidden="true"></i>
                    </li>
                    <li class="step__divider"></li>
                    <li class="step__item {{ is_active_route('installer.environment') }}">
                        @if(Request::is('install/environment') )
                            <a href="{{ route('installer.environment') }}">
                                <i class="step__icon fa fa-cog" aria-hidden="true"></i>
                            </a>
                        @else
                            <i class="step__icon fa fa-cog" aria-hidden="true"></i>
                        @endif
                    </li>
                    <li class="step__divider"></li>
                    <li class="step__item {{ is_active_route('installer.permissions') }}">
                        @if(Request::is('install/permissions') || Request::is('install/environment') || Request::is('install/environment/wizard') || Request::is('install/environment/classic') )
                            <a href="{{ route('installer.permissions') }}">
                                <i class="step__icon fa fa-key" aria-hidden="true"></i>
                            </a>
                        @else
                            <i class="step__icon fa fa-key" aria-hidden="true"></i>
                        @endif
                    </li>
                    <li class="step__divider"></li>
                    <li class="step__item {{ is_active_route('installer.requirements') }}">
                        @if(Request::is('install') || Request::is('install/requirements') || Request::is('install/permissions') || Request::is('install/environment') || Request::is('install/environment/wizard') || Request::is('install/environment/classic') )
                            <a href="{{ route('installer.requirements') }}">
                                <i class="step__icon fa fa-list" aria-hidden="true"></i>
                            </a>
                        @else
                            <i class="step__icon fa fa-list" aria-hidden="true"></i>
                        @endif
                    </li>
                    <li class="step__divider"></li>
                    <li class="step__item {{ is_active_route('installer.welcome') }}">
                        @if(Request::is('install') || Request::is('install/requirements') || Request::is('install/permissions') || Request::is('install/environment') || Request::is('install/environment/wizard') || Request::is('install/environment/classic') )
                            <a href="{{ route('installer.welcome') }}">
                                <i class="step__icon fa fa-home" aria-hidden="true"></i>
                            </a>
                        @else
                            <i class="step__icon fa fa-home" aria-hidden="true"></i>
                        @endif
                    </li>
                    <li class="step__divider"></li>
                </ul>
                <div class="main">
                    @if ($message = session('message'))
                        @php
                        if (is_string($message)) {
                            $message = [
                                'message' => $message,
                                'status' => 'success'
                            ];
                        }
                        @endphp

                        <p class="alert alert-{{ $message['status'] == 'error' ? 'danger' : $message['status'] }} text-center">
                            <strong>
                                {{ $message['message'] }}
                            </strong>
                        </p>
                    @endif

                    @yield('container')
                </div>
            </div>
        </div>

        @yield('scripts')

        <script type="text/javascript">
            var x = document.getElementById('error_alert');
            var y = document.getElementById('close_alert');
            if (x && y) {
                y.onclick = function() {
                    x.style.display = "none";
                };
            }
        </script>
    </body>
</html>
