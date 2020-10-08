<form method="post" action="{{ route('admin.setting.save') }}" class="form-ajax">
    <input type="hidden" name="form" value="recaptcha">
    @php
    $google_recaptcha = get_config('google_recaptcha');
    @endphp
    <div class="form-group">
        <label class="col-form-label" for="google_recaptcha">@lang('app.google_recaptcha')</label>
        <select name="google_recaptcha" id="google_recaptcha" class="form-control">
            <option value="1" @if($google_recaptcha == 1) selected @endif>@lang('app.enabled')</option>
            <option value="0" @if($google_recaptcha == 0) selected @endif>@lang('app.disabled')</option>
        </select>
    </div>

    <div class="form-group">
        <label class="col-form-label" for="google_recaptcha_key">@lang('app.google_recaptcha_key')</label>

        <input type="text" name="google_recaptcha_key" class="form-control" id="google_recaptcha_key" value="{{ get_config('google_recaptcha_key') }}" autocomplete="off">
    </div>

    <div class="form-group">
        <label class="col-form-label" for="google_recaptcha_secret">@lang('app.google_recaptcha_secret')</label>

        <input type="text" name="google_recaptcha_secret" class="form-control" id="google_recaptcha_secret" value="{{ get_config('google_recaptcha_secret') }}" autocomplete="off">
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