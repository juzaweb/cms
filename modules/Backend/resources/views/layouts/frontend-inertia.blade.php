<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <link href="//fonts.googleapis.com" rel="dns-prefetch"/>
    <link href="//www.gstatic.com" rel="dns-prefetch"/>
    <link href="//www.googletagmanager.com" rel="dns-prefetch"/>

{{--    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" />--}}
{{--    <script src="{{ theme_assets('assets/js/app.js') }}" defer></script>--}}

    @do_action('theme.header')

    @viteReactRefresh
    @vite(['resources/js/app.tsx', "resources/js/pages/{$page['component']}.tsx"])

    @inertiaHead

    <script>
        let darkModeMediaQuery = window.matchMedia('(prefers-color-scheme: dark)')

        updateMode()
        darkModeMediaQuery.addEventListener('change', updateModeWithoutTransitions)
        window.addEventListener('storage', updateModeWithoutTransitions)

        function updateMode() {
            let isSystemDarkMode = darkModeMediaQuery.matches
            let isDarkMode = window.localStorage.isDarkMode === 'true' || (!('isDarkMode' in window.localStorage) && isSystemDarkMode)

            if (isDarkMode) {
                document.documentElement.classList.add('dark')
            } else {
                document.documentElement.classList.remove('dark')
            }

            if (isDarkMode === isSystemDarkMode) {
                delete window.localStorage.isDarkMode
            }
        }

        function disableTransitionsTemporarily() {
            document.documentElement.classList.add('[&_*]:!transition-none')
            window.setTimeout(() => {
                document.documentElement.classList.remove('[&_*]:!transition-none')
            }, 0)
        }

        function updateModeWithoutTransitions() {
            disableTransitionsTemporarily()
            updateMode()
        }
    </script>
</head>

<body class="{{ $bodyClass ?? '' }}">
@do_action('theme.after_body')

@include('theme::header')

@inertia

@include('theme::footer')

@do_action('theme.footer')

</body>
</html>
