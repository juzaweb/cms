@extends('cms::layouts.backend')

@section('content')

    <div class="row">
        <div class="col-md-8"></div>

        <div class="col-md-4 text-right">
            <button type="button" class="btn btn-success">
                {{ trans('cms::app.upload_theme') }}
            </button>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-12">
            <form action="{{ route('admin.theme.install.upload') }}" role="form" id="uploadForm" name="uploadForm" method="post" class="dropzone" enctype="multipart/form-data">
                <div class="form-group" id="attachment">
                    <div class="controls text-center">
                        <div class="input-group w-100">
                            <a class="btn btn-primary w-100 text-white" id="upload-button">{{ trans('cms::filemanager.message-choose') }}</a>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
        </div>
    </div>

    <div class="row" id="theme-list"></div>

    <template id="theme-template">
        <div class="col-md-4">
            <div class="card">
                <div class="height-200 d-flex flex-column jw__g13__head" style="background-image: url('{screenshot}')">
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
    </script>
@endsection
