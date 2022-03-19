<div class="modal fade" id="upload-modal" tabindex="-1" role="dialog" aria-labelledby="upload-modal-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="upload-modal-label">
                    {{ trans(('cms::app.upload_media')) }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('cms::app.close') }}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('filemanager.upload') }}" role='form' id='uploadForm' name='uploadForm' method='post' class="dropzone" enctype='multipart/form-data'>

                    <div class="form-group" id="attachment">
                        <div class="controls text-center">
                            <div class="input-group w-100">
                                <a class="btn btn-primary w-100 text-white" id="upload-button">{{ trans('cms::filemanager.message-choose') }}</a>
                            </div>
                        </div>
                    </div>

                    <input type='hidden' name='working_dir' id='working_dir' value="{{ $folderId }}">
                    <input type='hidden' name='type' id='type' value='{{ $type }}'>
                    <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> @lang('cms::app.close')</button>
            </div>
        </div>
    </div>
</div>