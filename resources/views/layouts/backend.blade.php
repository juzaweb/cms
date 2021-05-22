<!DOCTYPE html>
<html lang="en" data-kit-theme="default">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="turbolinks-cache-control" content="no-cache">

    <title>@yield('title')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}" />
    <link href="https://fonts.googleapis.com/css?family=Mukta:400,700,800&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/backend.css') }}">
    <script type="text/javascript">
        var langs = {
            'are_you_sure_delete_items': '@lang('app.are_you_sure_delete_items')',
            'yes': '@lang('app.yes')',
            'cancel': '@lang('app.cancel')',
            'data_error': '@lang('app.data_error')',
            'enabled': '@lang('app.enabled')',
            'disabled': '@lang('app.disabled')',
            'options': '@lang('app.options')',
            'edit': '@lang('app.edit')',
            'translate': '@lang('app.translate')',
            'preview': '@lang('app.preview')',
            'upload_videos': '@lang('app.upload_videos')',
            'download_videos': '@lang('app.download_videos')',
            'add_subtitle': '@lang('app.add_subtitle')',
            'stream': '@lang('app.stream')',
        }
    </script>

    <script src="{{ asset('js/backend.js') }}"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>

</head>

<body class="cui__menuLeft--dark cui__topbar--fixed cui__menuLeft--unfixed">
<div class="cui__layout cui__layout--hasSider">

    <div class="cui__menuLeft">
        <div class="cui__menuLeft__mobileTrigger"><span></span></div>

        <div class="cui__menuLeft__outer">
            <div class="cui__menuLeft__logo__container">
                <div class="cui__menuLeft__logo">
                    <img src="{{ asset('images/logo.png') }}" class="mr-2" alt="Mymo Logo" />
                </div>
            </div>

            <div class="cui__menuLeft__scroll kit__customScroll">
                @include('backend.menu_left')
            </div>
        </div>
    </div>
    <div class="cui__menuLeft__backdrop"></div>

    <div class="cui__layout">
        <div class="cui__layout__header">
            @include('backend.menu_top')
        </div>
        <div class="cui__layout__content">
            @yield('content')
        </div>
        <div class="cui__layout__footer">
            <div class="cui__footer">
                <div class="cui__footer__inner">
                    <a href="https://mymo.juzaweb.com" target="_blank" rel="noopener noreferrer" class="cui__footer__logo">
                        MYMO
                        <span></span>
                    </a>
                    <br />
                    <p class="mb-0">
                        Copyright © 2020 MyMo Team
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    $.extend( $.validator.messages, {
        required: "{{ trans('app.this_field_is_required') }}",
    });

    $(".form-ajax").validate();
</script>
</body>
</html>