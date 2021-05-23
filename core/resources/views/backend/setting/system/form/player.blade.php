<form method="post" action="{{ route('admin.setting.save') }}" class="form-ajax">
    <input type="hidden" name="form" value="player">
    @php
        $player_watermark = get_config('player_watermark');
    @endphp
    <div class="form-group">
        <label class="col-form-label" for="player_watermark">@lang('app.player_watermark')</label>
        <select name="player_watermark" id="player_watermark" class="form-control">
            <option value="1" @if($player_watermark == 1) selected @endif>@lang('app.enabled')</option>
            <option value="0" @if($player_watermark == 0) selected @endif>@lang('app.disabled')</option>
        </select>
    </div>

    <div class="form-group">
        <label class="col-form-label" for="logo">@lang('app.player_watermark_logo') <span class="float-right"><a href="javascript:void(0)" data-input="player_watermark_logo" data-preview="preview-watermark_logo" class="lfm"><i class="fa fa-edit"></i> @lang('app.change_image')</a></span></label>
        <div id="preview-watermark_logo" class="preview-image">
            <img src="{{ image_url(get_config('player_watermark_logo')) }}" alt="" class="w-100">
        </div>
        <input id="player_watermark_logo" class="form-control" type="hidden" name="player_watermark_logo" value="{{ get_config('player_watermark_logo') }}">
    </div>

    <div class="row">
        <div class="col-md-6"></div>

        <div class="col-md-6">
            <div class="btn-group float-right">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-save"></i> @lang('app.save')
                </button>

                <button type="reset" class="btn btn-default">
                    <i class="fa fa-refresh"></i> @lang('app.reset')
                </button>
            </div>
        </div>
    </div>
</form>