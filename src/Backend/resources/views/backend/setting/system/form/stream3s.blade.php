<form method="post" action="{{ route('admin.setting.save') }}" class="form-ajax">
    @php
        $stream3s_use = get_config('stream3s_use');
        $stream3s_link = get_config('stream3s_link');
    @endphp
    <input type="hidden" name="form" value="stream3s">

    <div class="form-group">
        <label class="col-form-label" for="stream3s_use">@lang('mymo::app.stream3s_stream')</label>
        <select name="stream3s_use" id="stream3s_use" class="form-control">
            <option value="1" @if($stream3s_use == 1) selected @endif>@lang('mymo::app.enabled')</option>
            <option value="0" @if($stream3s_use == 0) selected @endif>@lang('mymo::app.disabled')</option>
        </select>
    </div>

    <div class="form-group">
        <label class="col-form-label" for="stream3s_link">@lang('mymo::app.stream3s_link')</label>
        <select name="stream3s_link" id="stream3s_link" class="form-control">
            <option value="embed" @if($stream3s_link == 'embed') selected @endif>Embed</option>
            <option value="direct" @if($stream3s_link == 'direct') selected @endif>Direct (Only Stream3s Premium Members)</option>
        </select>
    </div>

    <div class="form-group">
        <label class="col-form-label" for="stream3s_client_id">@lang('mymo::app.client_id')</label>
        <input type="text" name="stream3s_client_id" class="form-control" id="stream3s_client_id" value="{{ get_config('stream3s_client_id') }}" autocomplete="off" required>
    </div>

    <div class="form-group">
        <label class="col-form-label" for="stream3s_secret_key">@lang('mymo::app.secret_key')</label>

        <input type="text" name="stream3s_secret_key" id="stream3s_secret_key" class="form-control" autocomplete="off">
    </div>

    <div class="row">
        <div class="col-md-6"></div>

        <div class="col-md-6">
            <div class="btn-group float-right">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-save"></i> @lang('mymo::app.save')
                </button>

                <button type="reset" class="btn btn-default">
                    <i class="fa fa-refresh"></i> @lang('mymo::app.reset')
                </button>
            </div>
        </div>
    </div>
</form>