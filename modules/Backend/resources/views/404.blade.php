<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="turbolinks-cache-control" content="no-cache">
    <title>404 - Page not found</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('jw-styles/juzaweb/css/vendor.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('jw-styles/juzaweb/css/backend.min.css') }}">
</head>

<body class="juzaweb__menuLeft--dark">
<div class="juzaweb__layout">
    <div class="juzaweb__layout">
        <div class="juzaweb__auth__containerInner">
            <div class="container pl-5 pr-5 pt-5 pb-5 mb-auto text-dark font-size-32">
                <div class="font-weight-bold mb-3">Page not found</div>
                <div class="text-gray-6 font-size-24">
                    This page is deprecated, deleted, or does not exist at all
                </div>
                <div class="font-weight-bold font-size-70 mb-1">404 —</div>
                <a href="{{ '/' }}" data-turbolinks="false" class="btn btn-outline-primary width-100">
                    Go Back
                </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
