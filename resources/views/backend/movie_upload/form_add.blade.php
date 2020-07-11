<div class="row form-upload-video mb-5 box-hidden">
    <div class="col-md-12">
        <form method="post" action="{{ route('admin.movies.servers.upload.save', ['mtype' => 'tv-series', 'server_id' => $server->id]) }}" class="form-ajax" data-success="add_file_success">
            <input type="hidden" name="id" id="id" value="">

            <div class="form-group">
                <label class="col-form-label" for="label">@lang('app.label')</label>

                <input type="text" name="label" class="form-control" id="label" autocomplete="off" required>
            </div>

            <div class="form-group">
                <label class="col-form-label" for="order">@lang('app.order')</label>

                <input type="text" name="order" class="form-control" id="order" autocomplete="off" required value="1">
            </div>

            <div class="form-group">
                <label class="col-form-label" for="source">@lang('app.source')</label>

                <select name="source" id="source" class="form-control" required>
                    <option value="">--- @lang('app.source') ---</option>
                    <option value="upload">Upload</option>
                    <option value="youtube">Youtube</option>
                    <option value="vimeo">Vimeo</option>
                    <option value="embed">Google Drive</option>
                    <option value="mp4" selected>MP4 From URL</option>
                    <option value="mkv">MKV From URL</option>
                    <option value="webm">WEBM From URL</option>
                    <option value="m3u8">M3U8 From URL</option>
                    <option value="embed">Embed URL</option>
                </select>
            </div>

            <div class="form-group form-url">
                <label class="col-form-label" for="url">@lang('app.video_url')</label>
                <input type="text" name="url" id="url" class="form-control" autocomplete="off">
            </div>

            <div class="form-group form-upload box-hidden">
                <label class="col-form-label" for="url_upload">@lang('app.video_url')</label>
                <div class="row">
                    <div class="col-md-10">
                        <input type="text" name="url_upload" id="url_upload" class="form-control" autocomplete="off">
                    </div>

                    <div class="col-md-2">
                        <a href="javascript:void(0)" class="btn btn-primary lfm-file" data-input="url_upload"><i class="fa fa-upload"></i> @lang('app.upload')</a>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> @lang('app.save')</button>
        </form>
    </div>
</div>