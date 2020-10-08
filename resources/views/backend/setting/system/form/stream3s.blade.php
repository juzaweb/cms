<form method="post" action="{{ route('admin.setting.save') }}" class="form-ajax">
    @php
        $stream3s_use = get_config('stream3s_use');
    @endphp

    <div class="form-group">
        <label class="col-form-label" for="user_registration">@lang('app.stream3s_stream')</label>
        <select name="user_registration" id="user_registration" class="form-control">
            <option value="1" @if($stream3s_use == 1) selected @endif>@lang('app.enabled')</option>
            <option value="0" @if($stream3s_use == 0) selected @endif>@lang('app.disabled')</option>
        </select>
    </div>

    <div class="form-group">
        <label class="col-form-label" for="stream3s_client_id">@lang('app.client_id')</label>
        <input type="text" name="stream3s_client_id" class="form-control" id="stream3s_client_id" value="{{ get_config('stream3s_client_id') }}" autocomplete="off" required>
    </div>

    <div class="form-group">
        <label class="col-form-label" for="stream3s_secret_key">@lang('app.secret_key')</label>

        <input type="text" name="stream3s_secret_key" id="stream3s_secret_key" class="form-control" value="{{ get_config('stream3s_secret_key') }}" autocomplete="off">
    </div>

</form>