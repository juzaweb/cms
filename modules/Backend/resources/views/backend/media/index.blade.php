@extends('cms::layouts.backend')

@section('content')
    <div id="media-container">
        <div class="row mb-2">
            <div class="col-md-8">
                <form action="" method="get" class="form-inline">
                    <input type="text" class="form-control w-25" name="search" placeholder="{{ trans('cms::app.search_by_name') }}" autocomplete="off">

                    <select name="type" class="form-control w-25 ml-1">
                        <option value="">{{ trans('cms::app.all_type') }}</option>
                        @foreach($fileTypes as $key => $val)
                            <option value="{{ $key }}" {{ $type == $key ? 'selected' : '' }}>{{ strtoupper($key) }}</option>
                        @endforeach
                    </select>

                    {{--<select name="mime" class="form-control w-25 ml-1">
                        <option value="">All media items</option>
                        <option value="image">Images</option>
                        <option value="audio">Audio</option>
                        <option value="video">Video</option>
                        <option value="application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-word.document.macroEnabled.12,application/vnd.ms-word.template.macroEnabled.12,application/vnd.oasis.opendocument.text,application/vnd.apple.pages,application/pdf,application/vnd.ms-xpsdocument,application/oxps,application/rtf,application/wordperfect,application/octet-stream">Documents</option>
                        <option value="application/vnd.apple.numbers,application/vnd.oasis.opendocument.spreadsheet,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel.sheet.macroEnabled.12,application/vnd.ms-excel.sheet.binary.macroEnabled.12">Spreadsheets</option>
                        <option value="application/x-gzip,application/rar,application/x-tar,application/zip,application/x-7z-compressed">Archives</option>
                        <option value="unattached">Unattached</option>
                        <option value="mine">Mine</option>
                    </select>--}}

                    <button type="submit" class="btn btn-primary ml-1">{{ trans('cms::app.search') }}</button>
                </form>
            </div>

            <div class="col-md-4">
                <div class="btn-group float-right">
                    <a href="javascript:void(0)" class="btn btn-success" data-toggle="modal" data-target="#add-folder-modal"><i class="fa fa-plus"></i> {{ trans('cms::app.add_folder') }}</a>
                    <a href="javascript:void(0)" class="btn btn-success" data-toggle="modal" data-target="#upload-modal"><i class="fa fa-cloud-upload"></i> {{ trans('cms::app.upload') }}</a>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-9">
                <div class="list-media">
                    <ul class="media-list">
                        @foreach($mediaFolders as $item)
                            @component('cms::backend.media.components.item', ['item' => $item])
                            @endcomponent
                        @endforeach

                        @foreach($mediaFiles as $item)
                            @component('cms::backend.media.components.item', ['item' => $item])
                            @endcomponent
                        @endforeach
                    </ul>
                </div>

                <div class="mt-3">
                    {{ $mediaFiles->appends(request()->query())->links() }}
                </div>
            </div>

            <div class="col-md-3" id="preview-file">
                <div class="preview">
                    <i class="fa fa-file-image-o"></i>
                </div>
                <p class="text-center">{{ trans('cms::app.media_setting.click_file_to_view_info') }}</p>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <template id="media-detail-template">
        <div class="box-image">
            <img src="{url}" alt="" class="preview-image">
        </div>

        <div class="mt-2 mb-3">
            <a href="{{ str_replace('__ID__', '{id}', route('admin.media.download', ['__ID__'])) }}">
                {{ trans('cms::app.download') }}
            </a>

            <a
                href="javascript:void(0)"
                class="text-danger delete-file"
                data-id="{id}"
                data-is_file="{is_file}"
                data-name="{name}"
            >{{ trans('cms::app.delete') }}</a>
        </div>

        <form
            action="{{ str_replace('__ID__', '{id}', route('admin.media.update', ['__ID__'])) }}"
            method="post"
            class="form-ajax"
        >
            @method('put')
            <input type="hidden" name="is_file" value="{is_file}">

            {{ Field::text(trans('cms::app.name'), 'name', ['value' => '{name}']) }}

            {{ Field::text(trans('cms::app.url'), 'url', ['value' => '{url}', 'disabled' => true]) }}

            <table class="table">
                <tbody>
                <tr>
                    <td>{{ trans('cms::app.extension') }}</td>
                    <td>{extension}</td>
                </tr>

                <tr>
                    <td>{{ trans('cms::app.size') }}</td>
                    <td>{size}</td>
                </tr>
                <tr>
                    <td>{{ trans('cms::app.last_update') }}</td>
                    <td>{updated}</td>
                </tr>
                </tbody>
            </table>

            <button type="submit" class="btn btn-primary mb-2">{{ trans('cms::app.save') }}</button>
        </form>

    </template>

    @include('cms::backend.media.components.add_modal')

    @include('cms::backend.media.components.upload_modal')

    <script>
        Dropzone.autoDiscover = false;

        $(document).ready(function () {
            new Dropzone("#uploadForm", {
                paramName: "upload",
                uploadMultiple: false,
                parallelUploads: 5,
                timeout: 0,
                clickable: '#upload-button',
                dictDefaultMessage: "{{ trans('cms::filemanager.message-drop') }}",
                init: function () {
                    this.on('success', function (file, response) {
                        if (response == 'OK') {
                            window.location = "";
                        } else {
                            this.defaultOptions.error(file, response.join('\n'));
                        }
                    });
                },
                headers: {
                    'Authorization': "Bearer {{ csrf_token() }}"
                },
                acceptedFiles: "{{ implode(',', $mimeTypes) }}",
                maxFilesize: parseInt("{{ $maxSize }}"),
                chunking: true,
                chunkSize: 1048576,
            });
        });

        function add_folder_success(form) {
            window.location = "";
        }
    </script>
@endsection
