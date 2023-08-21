<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=EDGE"/>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="theme-color" content="#333844">
        <meta name="msapplication-navbutton-color" content="#333844">
        <meta name="apple-mobile-web-app-status-bar-style" content="#333844">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ trans('cms::filemanager.title-page') }}</title>
        <link rel="shortcut icon" type="image/png" href="{{ asset('jw-styles/juzaweb/images/favicon.ico') }}">
        {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.css">--}}
        <link rel="stylesheet" href="{{ asset('jw-styles/juzaweb/css/filemanager.min.css') }}">
    </head>
<body>

<nav class="navbar sticky-top navbar-expand-lg navbar-dark" id="nav">
    <a class="navbar-brand invisible-lg d-none d-lg-inline" id="to-previous">
        <i class="fa fa-arrow-left fa-fw"></i>
        <span class="d-none d-lg-inline">{{ trans('cms::filemanager.nav-back') }}</span>
    </a>
    <a class="navbar-brand d-block d-lg-none" id="show_tree">
        <i class="fa fa-bars fa-fw"></i>
    </a>
    <a class="navbar-brand d-block d-lg-none" id="current_folder"></a>
    <a id="loading" class="navbar-brand"><i class="fa fa-spinner fa-spin"></i></a>
    <div class="ml-auto px-2">
        {{--<a class="navbar-link d-none" id="multi_selection_toggle">
            <i class="fa fa-check-double fa-fw"></i>
            <span class="d-none d-lg-inline">{{ trans('cms::filemanager.menu-multiple') }}</span>
        </a>--}}
    </div>
    <a class="navbar-toggler collapsed border-0 px-1 py-2 m-0" data-toggle="collapse" data-target="#nav-buttons">
        <i class="fa fa-cog fa-fw"></i>
    </a>
    <div class="collapse navbar-collapse flex-grow-0" id="nav-buttons">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-display="grid">
                    <i class="fa fa-th-large fa-fw"></i>
                    <span>{{ trans('cms::filemanager.nav-thumbnails') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-display="list">
                    <i class="fa fa-list-ul fa-fw"></i>
                    <span>{{ trans('cms::filemanager.nav-list') }}</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-sort fa-fw"></i>{{ trans('cms::filemanager.nav-sort') }}
                </a>
                <div class="dropdown-menu dropdown-menu-right border-0"></div>
            </li>
        </ul>
    </div>
</nav>

<nav class="bg-light fixed-bottom border-top d-none" id="actions">
    <a data-action="open" data-multiple="false"><i class="fa fa-folder-open"></i>{{ trans('cms::filemanager.btn-open') }}
    </a>
    <a data-action="preview" data-multiple="true"><i class="fa fa-images"></i>{{ trans('cms::filemanager.menu-view') }}
    </a>
    <a data-action="use" data-multiple="true"><i class="fa fa-check"></i>{{ trans('cms::filemanager.btn-confirm') }}
    </a>
</nav>

<div class="d-flex flex-row">
    <div id="tree"></div>

    <div id="main">
        <div id="alerts"></div>

        <nav aria-label="breadcrumb" class="d-none d-lg-block" id="breadcrumbs">
            <ol class="breadcrumb">
                <li class="breadcrumb-item invisible">Home</li>
            </ol>
        </nav>

        <div id="empty" class="d-none">
            <i class="fa fa-folder-open"></i>
            {{ trans('cms::filemanager.message-empty') }}
        </div>

        <div id="content"></div>
        <div id="pagination"></div>

        <a id="item-template" class="d-none">
            <div class="square"></div>

            <div class="info">
                <div class="item_name text-truncate"></div>
                <time class="text-muted font-weight-light text-truncate"></time>
            </div>
        </a>
    </div>

    <div id="fab"></div>
</div>

<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active text-capitalize" id="upload-tab" data-toggle="tab" href="#upload-form" role="tab" aria-controls="upload-form" aria-selected="true">{{ trans(('cms::app.upload_media')) }}</a>
                        </li>
                        @if(config('juzaweb.filemanager.upload_from_url'))
                            <li class="nav-item">
                                <a class="nav-link text-capitalize" id="import-tab" data-toggle="tab" href="#import-form" role="tab" aria-controls="import-form" aria-selected="false">{{ trans('cms::app.file_manager.upload_from_url') }}</a>
                            </li>
                        @endif
                    </ul>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aia-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="upload-form" role="tabpanel" aria-labelledby="upload-tab">
                        <form action="{{ route('filemanager.upload') }}" role='form' id='uploadForm' name='uploadForm' method='post' enctype='multipart/form-data' class="dropzone">
                            <div class="form-group" id="attachment">
                                <div class="controls text-center">
                                    <div class="input-group w-100">
                                        <a class="btn btn-primary w-100 text-white" id="upload-button">{{ trans('cms::filemanager.message-choose') }}</a>
                                    </div>
                                </div>
                            </div>
                            <input type='hidden' name='working_dir' class='working_dir'>
                            <input type='hidden' name='type' class='type' value='{{ request("type") }}'>
                            <input type='hidden' name='disk' class='disk' value='{{ request()->get('disk') }}'>
                            <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="import-form" role="tabpanel" aria-labelledby="import-tab">
                        <form action="{{ route('filemanager.import') }}" role="form" method="post" id="import-url">

                            {{ Field::text(trans('cms::app.url'), 'url', ['required' => true]) }}

                            <div class="form-check">
                                <input type="checkbox" name="download" class="form-check-input" value="1" id="download-checkbox" checked>
                                <label class="form-check-label" for="download-checkbox">{{ trans('cms::app.file_manager.download_to_server') }}</label>
                            </div>

                            <input type="hidden" name="working_dir" class='working_dir'>
                            <input type="hidden" name="type" class="type" value="{{ request("type") }}">
                            <input type='hidden' name='disk' value='{{ request()->get('disk') }}'>

                            <button type="submit" class="btn btn-success mt-2">
                                <i class="fa fa-cloud-upload"></i> {{ trans('cms::app.file_manager.upload_file') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary w-100" data-dismiss="modal">
                    {{ trans('cms::filemanager.btn-close') }}
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="notify" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary w-100" data-dismiss="modal">{{ trans('cms::filemanager.btn-close') }}</button>
                <button type="button" class="btn btn-primary w-100" data-dismiss="modal">{{ trans('cms::filemanager.btn-confirm') }}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="dialog" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary w-100" data-dismiss="modal">{{ trans('cms::filemanager.btn-close') }}</button>
                <button type="button" class="btn btn-primary w-100" data-dismiss="modal">{{ trans('cms::filemanager.btn-confirm') }}</button>
            </div>
        </div>
    </div>
</div>

<div id="carouselTemplate" class="d-none carousel slide bg-light" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#previewCarousel" data-slide-to="0" class="active"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <a class="carousel-label"></a>
            <div class="carousel-image"></div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#previewCarousel" role="button" data-slide="prev">
        <div class="carousel-control-background" aria-hidden="true">
            <i class="fa fa-chevron-left"></i>
        </div>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#previewCarousel" role="button" data-slide="next">
        <div class="carousel-control-background" aria-hidden="true">
            <i class="fa fa-chevron-right"></i>
        </div>
        <span class="sr-only">Next</span>
    </a>
</div>

<script>
    var lang = @json(trans('cms::filemanager'));
    var actions = [
        // {
        //   name: 'use',
        //   icon: 'check',
        //   label: 'Confirm',
        //   multiple: true
        // },
        /*{
            name: 'rename',
            icon: 'edit',
            label: lang['menu-rename'],
            multiple: false
        },
        {
            name: 'download',
            icon: 'download',
            label: lang['menu-download'],
            multiple: true
        },*/
        // {
        //   name: 'preview',
        //   icon: 'image',
        //   label: lang['menu-view'],
        //   multiple: true
        // },
        /* {
             name: 'move',
             icon: 'paste',
             label: lang['menu-move'],
             multiple: true
         },
         {
             name: 'resize',
             icon: 'arrows-alt',
             label: lang['menu-resize'],
             multiple: false
         },
         {
             name: 'crop',
             icon: 'crop',
             label: lang['menu-crop'],
             multiple: false
         },*/
        {
            name: 'trash',
            icon: 'trash',
            label: lang['menu-delete'],
            multiple: true
        },
    ];

    const sortings = [
        {
            by: 'alphabetic',
            icon: 'sort-alpha-down',
            label: lang['nav-sort-alphabetic']
        },
        {
            by: 'time',
            icon: 'sort-numeric-down',
            label: lang['nav-sort-time']
        }
    ];

    let multi_selection_enabled = @if($multiChoose == 1) true @else false @endif;
</script>
<script src="{{ asset('jw-styles/juzaweb/js/filemanager.min.js') }}?v={{ \Juzaweb\CMS\Version::getVersion() }}"></script>

<script>
    Dropzone.options.uploadForm = {
        paramName: "upload",
        uploadMultiple: false,
        parallelUploads: 5,
        timeout: 0,
        clickable: '#upload-button',
        dictDefaultMessage: lang['message-drop'],
        init: function () {
            this.on('success', function (file, response) {
                loadFolders();
            });
        },
        headers: {
            'Authorization': 'Bearer ' + getUrlParam('token')
        },
        acceptedFiles: "{{ implode(',', $mimeTypes) }}",
        maxFilesize: parseInt("{{ $maxSize }}"),
        chunking: true,
        forceChunking: true,
        chunkSize: 1048576,
    }
</script>
</body>
</html>
