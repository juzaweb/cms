@extends('network::layout')

@section('content')

    <div class="row box-hidden mb-2" id="form-theme-upload">
        <div class="col-md-12">
            <form action="{{ route('admin.theme.install.upload') }}" role="form" id="themeUploadForm" name="themeUploadForm" method="post" class="dropzone" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="controls text-center">
                        <div class="input-group w-100">
                            <a class="btn btn-primary w-100 text-white" id="theme-upload-button">{{ trans('cms::filemanager.message-choose') }}</a>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8"></div>

        <div class="col-md-4 text-right">
            <button type="button" class="btn btn-success" id="upload-theme">
                {{ trans('cms::app.upload_theme') }}
            </button>
        </div>
    </div>

    <div class="row" id="theme-list"></div>

    <template id="theme-template">
        <div class="col-md-4">
            <div class="card">
                <div class="height-200 d-flex flex-column jw__g13__head" style="background-repeat: no-repeat;
    background-size: 395px 200px;background-image: url('{screenshot}')">
                </div>

                <div class="card card-borderless mb-0">
                    <div class="card-header border-bottom-0">
                        <div class="d-flex">
                            <div class="text-dark text-uppercase font-weight-bold mr-auto">
                                {title}
                            </div>
                            <div class="text-gray-6">
                                <button class="btn btn-primary install-theme" data-theme="{name}"> {{ trans('cms::app.install') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <script>
        var listView = new JuzawebListView({
            url: "{{ route('admin.theme.install.all') }}",
            list: "#theme-list",
            template: "theme-template",
            page_size: 9,
        });

        Dropzone.autoDiscover = false;

        $(function() {
            new Dropzone("#themeUploadForm", {
                uploadMultiple: false,
                parallelUploads: 5,
                timeout: 0,
                clickable: '#theme-upload-button',
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

            $('body').on('click', '#upload-theme', function () {
                let frm = $('#form-theme-upload');
                if(frm.is(':hidden')) {
                    frm.show('slow');
                } else {
                    frm.hide('slow');
                }
            });
        });
    </script>
@endsection
