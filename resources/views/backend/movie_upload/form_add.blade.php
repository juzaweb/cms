<div class="row form-upload-video mb-5 box-hidden">
    <div class="col-md-12">
        <form method="post" action="" class="form-ajax">
            <input type="hidden" name="id" value="">

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

            <div class="form-group form-upload">
                <div class="upload-file" id="dropTarget">
                    <a href="javascript:void(0)" id="browseButton">@lang('app.choose_file_upload')</a>
                </div>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fa fa-plus-circle"></i> @lang('app.add_video')</button>
        </form>
    </div>
</div>