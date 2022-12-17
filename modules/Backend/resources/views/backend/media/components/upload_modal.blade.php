<div class="modal fade" id="upload-modal" tabindex="-1" role="dialog" aria-labelledby="upload-modal-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="upload-modal-label">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active text-capitalize" id="upload-tab" data-toggle="tab" href="#upload" role="tab" aria-controls="home" aria-selected="true">{{ trans(('cms::app.upload_media')) }}</a>
                        </li>
                        @if(config('juzaweb.filemanager.upload_from_url'))
                        <li class="nav-item">
                            <a class="nav-link text-capitalize" id="import-tab" data-toggle="tab" href="#import" role="tab" aria-controls="profile" aria-selected="false">{{ trans('cms::app.file_manager.upload_from_url') }}</a>
                        </li>
                        @endif
                    </ul>
                </h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('cms::app.close') }}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="upload" role="tabpanel" aria-labelledby="upload-tab">
                        <form action="{{ route('filemanager.upload') }}" role="form" id="uploadForm" name="uploadForm" method="post" class="dropzone" enctype='multipart/form-data'>

                            <div class="form-group" id="attachment">
                                <div class="controls text-center">
                                    <div class="input-group w-100">
                                        <a class="btn btn-primary w-100 text-white" id="upload-button">
                                            {{ trans('cms::filemanager.message-choose') }}
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="working_dir" id='working_dir' value="{{ $folderId }}">
                            <input type="hidden" name="type" id="type" value="{{ $type }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </form>
                    </div>

                    <div class="tab-pane fade" id="import" role="tabpanel" aria-labelledby="import-tab">
                        <form action="{{ route('filemanager.import') }}" role="form" method="post" class="form-ajax" data-success="add_folder_success">

                            {{ Field::text(trans('cms::app.url'), 'url', ['required' => true]) }}

                            <div class="form-check">
                                <input type="checkbox" name="download" class="form-check-input" value="1" id="download-checkbox" checked>
                                <label class="form-check-label" for="download-checkbox">{{ trans('cms::app.file_manager.download_to_server') }}</label>
                            </div>

                            <input type="hidden" name="working_dir" id='working_dir' value="{{ $folderId }}">
                            <input type="hidden" name="type" id="type" value="{{ $type }}">

                            <button type="submit" class="btn btn-success mt-2">
                                <i class="fa fa-cloud-upload"></i> {{ trans('cms::app.file_manager.upload_file') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> {{ trans('cms::app.close') }}
                </button>
            </div>
        </div>
    </div>
</div>
