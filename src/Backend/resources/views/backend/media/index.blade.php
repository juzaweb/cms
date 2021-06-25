@extends('mymo::layouts.admin')

@section('content')
    <div class="row mb-2">
        <div class="col-md-8">

            <form action="" method="get" class="form-inline">
                <input type="text" class="form-control w-25" name="search" placeholder="Search by name" autocomplete="off">

                <select name="type" class="form-control w-25 ml-1">
                    <option value="">All type</option>
                    @foreach($fileTypes as $key => $type)
                    <option value="{{ $key }}" {{ request()->query('type') == $key ? 'selected' : '' }}>{{ strtoupper($key) }}</option>
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

                <button type="submit" class="btn btn-primary ml-1">@lang('mymo::app.search')</button>
            </form>
        </div>

        <div class="col-md-4">
            <div class="btn-group float-right">
                <a href="javascript:void(0)" class="btn btn-success" data-toggle="modal" data-target="#add-folder-modal"><i class="fa fa-plus"></i> @lang('mymo::app.add-folder')</a>
                <a href="javascript:void(0)" class="btn btn-success" data-toggle="modal" data-target="#upload-modal"><i class="fa fa-cloud-upload"></i> @lang('mymo::app.upload')</a>
            </div>
        </div>
    </div>

    <div class="list-media mt-5">
        //item
    </div>
@endsection

@section('footer')
    <div class="modal fade" id="add-folder-modal" tabindex="-1" role="dialog" aria-labelledby="add-folder-modal-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('admin.media.add-folder') }}" method="post" class="form-ajax">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="add-folder-modal-label">@lang('mymo::app.add-folder')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('mymo::app.close') }}">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @component('mymo::components.form_input', [
                            'label' => trans('mymo::app.folder-name'),
                            'name' => 'name'
                        ])
                        @endcomponent


                        <input type="hidden" name="parent_id" value="{{ $folderId }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> @lang('mymo::app.close')</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('mymo::app.add-folder')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="upload-modal" tabindex="-1" role="dialog" aria-labelledby="upload-modal-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="upload-modal-label">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group" id="attachment">
                        <div class="controls text-center">
                            <div class="text-center">
                                <a href="javascript:void(0)" class="btn btn-primary rounded-0" id="upload-button"><i class="fa
                                fa-cloud-upload"></i> {{ trans('filemanager::file-manager.message-choose') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <input type='hidden' name='working_dir' id='working_dir'>
                    <input type='hidden' name='previous_dir' id='previous_dir'>
                    <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> @lang('mymo::app.close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection