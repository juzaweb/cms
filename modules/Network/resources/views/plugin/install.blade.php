@extends('network::layout')

@section('content')

    <div class="row box-hidden mb-2" id="form-plugin-upload">
        <div class="col-md-12">
            <form action="{{ route('admin.plugin.install.upload') }}" role="form" id="pluginUploadForm" name="pluginUploadForm" method="post" class="dropzone" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="controls text-center">
                        <div class="input-group w-100">
                            <a class="btn btn-primary w-100 text-white" id="plugin-upload-button">{{ trans('cms::filemanager.message-choose') }}</a>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-8"></div>

        <div class="col-md-4 text-right">
            <button type="button" class="btn btn-success" id="upload-plugin">
                {{ trans('cms::app.upload_plugin') }}
            </button>
        </div>
    </div>

    <div class="row" id="plugin-list"></div>

    <template id="plugin-template">
        <div class="col-md-4">
            <div class="card p-3">
                <div class="d-flex flex-row mb-3">
                    <img src="{thumbnail}" alt="{title}" width="70" height="70">
                    <div class="d-flex flex-column ml-2">
                        <span>{title}</span>
                        {{--<span class="text-black-50">Payment Services</span>--}}

                        <span class="ratings text-secondary">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </span>
                    </div>
                </div>
                <h6>{description}</h6>
                <div class="d-flex justify-content-between install mt-3">
                    {{--<span>Installed 172 times</span>--}}
                    <button
                        class="btn btn-primary install-plugin"
                        data-plugin="{name}"
                    >{{ trans('cms::app.install') }}</button>

                    {{--<a target="_blank" href="{url}" class="text-primary">
                        {{ trans('cms::app.view') }}&nbsp;<i class="fa fa-angle-right"></i>
                    </a>--}}
                </div>
            </div>
        </div>
    </template>

    <script>
        var listView = new JuzawebListView({
            url: "{{ route('admin.plugin.install.all') }}",
            list: "#plugin-list",
            template: "plugin-template"
        });

        Dropzone.autoDiscover = false;

        $(document).ready(function () {
            new Dropzone("#pluginUploadForm", {
                uploadMultiple: false,
                parallelUploads: 5,
                timeout: 0,
                clickable: '#plugin-upload-button',
                dictDefaultMessage: "{{ trans('cms::filemanager.message-drop') }}",
                init: function () {
                    this.on('success', function (file, response) {
                        if(response.status == false) {
                            this.defaultOptions.error(file, response.data.message);
                        }
                    });
                },
                headers: {
                    'Authorization': "Bearer {{ csrf_token() }}"
                },
                acceptedFiles: "application/zip,.zip",
                maxFilesize: 1024,
                chunking: true,
                chunkSize: 1048576,
            });

            $('body').on('click', '#upload-plugin', function () {
                let frm = $('#form-plugin-upload');
                if(frm.is(':hidden')) {
                    frm.show('slow');
                } else {
                    frm.hide('slow');
                }
            });
        });
    </script>
@endsection
