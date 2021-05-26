<form method="post" action="{{ route('admin.setting.save') }}" class="form-ajax">
    <input type="hidden" name="form" value="recaptcha">
    @php
    $google_recaptcha = get_config('google_recaptcha');
    @endphp
    <div class="form-group">
        <label class="col-form-label" for="google_recaptcha">@lang('mymo_core::app.google_recaptcha')</label>
        <select name="google_recaptcha" id="google_recaptcha" class="form-control">
            <option value="1" @if($google_recaptcha == 1) selected @endif>@lang('mymo_core::app.enabled')</option>
            <option value="0" @if($google_recaptcha == 0) selected @endif>@lang('mymo_core::app.disabled')</option>
        </select>
    </div>

    <div class="form-group">
        <label class="col-form-label" for="google_recaptcha_key">@lang('mymo_core::app.google_recaptcha_key')</label>

        <input type="text" name="google_recaptcha_key" class="form-control" id="google_recaptcha_key" value="{{ get_config('google_recaptcha_key') }}" autocomplete="off">
    </div>

    <div class="form-group">
        <label class="col-form-label" for="google_recaptcha_secret">@lang('mymo_core::app.google_recaptcha_secret')</label>

        <input type="text" name="google_recaptcha_secret" class="form-control" id="google_recaptcha_secret" value="{{ get_config('google_recaptcha_secret') }}" autocomplete="off">
    </div>

    <div class="row">
        <div class="col-md-6"></div>

        <div class="col-md-6">
            <div class="btn-group float-right">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-save"></i> @lang('mymo_core::app.save')
                </button>

                <button type="reset" class="btn btn-default">
                    <i class="fa fa-refresh"></i> @lang('mymo_core::app.reset')
                </button>
            </div>
        </div>
    </div>
</form>