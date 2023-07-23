<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>{{ trans('cms::app.customize_theme') }}</title>
    <meta name="description" content="{{ trans('cms::app.customize_theme') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

    @include('cms::components.juzaweb_langs')

    <link rel="shortcut icon" href="{{ asset('jw-styles/juzaweb/images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('jw-styles/juzaweb/css/theme-editor.css') }}">
    <!--[if lt IE 9]>
    <script src="{{ asset('jw-styles/juzaweb/js/html5shiv.min.js') }}"></script>
    <script src="{{ asset('jw-styles/juzaweb/js/respond.min.js') }}"></script>
    <![endif]-->

    <script src="{{ asset('jw-styles/juzaweb/js/theme-editor.js') }}"></script>

    @viteReactRefresh

    @vite(["resources/js/app.tsx", "resources/css/app.css", "resources/js/pages/{$page['component']}.tsx"])

    @inertiaHead

    {{--<script type="text/javascript">
        $(document).ajaxStart(function () {
            Juzaweb.Loading.start();
        });
        $(document).ajaxComplete(function () {
            Juzaweb.Loading.stop();
        });

        setInterval(function () {
            Juzaweb.CSRFToken.update();
        }, 3600000);
    </script>--}}
</head>
<body class="body-theme-editor theme-editor sfe-next fresh-ui next-ui" id="theme-editor" style="height: 100% !important;">
<div class="ui-flash-container">
    <div class="ui-flash-wrapper" id="UIFlashWrapper">
        <div class="ui-flash ui-flash--nav-offset" id="UIFlashMessage"><p class="ui-flash__message"></p><div class='ui-flash__close-button'><button class='ui-button ui-button--transparent ui-button--icon-only ui-button-flash-close' aria-label='Close message' type='button' name='button'><svg class='next-icon next-icon--color-white next-icon--size-12'><use xmlns:xlink='http://www.w3.org/1999/xlink' xlink:href='#next-remove'><svg id='next-remove' width='100%' height='100%'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><path d='M18.263 16l10.07-10.07c.625-.625.625-1.636 0-2.26s-1.638-.627-2.263 0L16 13.737 5.933 3.667c-.626-.624-1.637-.624-2.262 0s-.624 1.64 0 2.264L13.74 16 3.67 26.07c-.626.625-.626 1.636 0 2.26.312.313.722.47 1.13.47s.82-.157 1.132-.47l10.07-10.068 10.068 10.07c.312.31.722.468 1.13.468s.82-.157 1.132-.47c.626-.625.626-1.636 0-2.26L18.262 16z'></path></svg></svg></use></svg></button></div>
        </div>
    </div>
</div>

<main class="theme-editor__wrapper" component="UI.Progress" define="{editorThemeV2: new Juzaweb.ThemeSettingsV2(this,{&quot;current_section&quot;:-1,&quot;id&quot;:731236})}"
      content="editorThemeV2">
    <div class="notifications">
        <div class="ajax-notification">
            <span class="ajax-notification-message"></span>
            <a class="close-notification" onclick="Juzaweb.Flash.hide()"><i class="fa fa-times"></i></a>
        </div>
    </div>

    {{--<script type="text/javascript">
        Page(function () {
            $(document).on("click", Juzaweb.SingleDropdown.checkFocus);
            document.addEventListener('page:before-replace', function () {
                $(document).off("click", Juzaweb.SingleDropdown.checkFocus);
            }, { once: true });
        });
    </script>--}}

    @inertia

    <div class="theme-editor__spinner" component="UI.Spinner">
        <div class="next-spinner">
            <svg class="next-icon next-icon--size-24"> <use xlink:href="#next-spinner" /> </svg>
        </div>
    </div>

</main>

@include('cms::backend.customizer.components.global_icon')

<div>
    <div class="section-footer">

        {{--<script type="text/javascript">
            $(document).ready(function () {
                $(".spectrum-color").spectrum({
                    showInput: true,
                    className: "full-spectrum",
                    showInitial: true,
                    showPalette: false,
                    showSelectionPalette: true,
                    maxSelectionSize: 10,
                    preferredFormat: "hex",
                    showButtons: false,
                    allowEmpty: true,
                    move: function (color) {
                        postMessageData("changeColor", {
                            key: $(this).data("color-setting"),
                            value: color ? color.toHexString() : null
                        });
                    },
                    show: function () {

                    },
                    beforeShow: function () {

                    },
                    hide: function () {

                    },
                    change: function (color) {
                        postMessageData("changeColor", {
                            key: $(this).data("color-setting"),
                            value: color ? color.toHexString() : null
                        });
                    }
                });
            });

            function postMessageData(message, data) {
                var postData = JSON.stringify({
                    message: message,
                    data: data
                });

                document.getElementById("theme-editor-iframe").contentWindow.postMessage(postData, window.location);

                if (data != null)
                    return data.callbackId

                return void 0;
            };

            function save_success(form, data) {
                let current_url = document.getElementById('theme-editor-iframe').src;
                $('#theme-editor-iframe').attr('src', current_url);
            }
        </script>--}}
    </div>
</div>

</body>
</html>
