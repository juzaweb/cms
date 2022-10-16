<form method="post" action="{{ route('admin.setting.save') }}" class="form-ajax">
    <input type="hidden" name="form" value="recaptcha">

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6"></div>

                <div class="col-md-6">
                    <div class="btn-group float-right">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> {{ trans('cms::app.save') }}
                        </button>

                        <button type="reset" class="btn btn-default">
                            <i class="fa fa-refresh"></i> {{ trans('cms::app.reset') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">

            <div class="row">
                @foreach($socials as $social)
                    <div class="col-md-6">
                        <h5>{{ trans("cms::app.socials.{$social}") }}</h5>

                        {{ Field::checkbox(trans('cms::app.enable'), "socialites[{$social}][enable]", [
                            'value' => '1',
                            'checked' => $data[$social]['enable'] ?? false
                        ]) }}

                        {{ Field::security(trans('cms::app.client_id'), "socialites[{$social}][client_id]", [
                            'value' => $data[$social]['client_id'] ?? ''
                        ]) }}

                        {{ Field::security(trans('cms::app.client_secret'), "socialites[{$social}][client_secret]", [
                            'value' => $data[$social]['client_secret'] ?? ''
                        ]) }}

                        {{ Field::text(trans('cms::app.callback_url'), "socialites[{$social}][redirect_url]", [
                            'disabled' => true,
                            'value' => route('auth.socialites.callback', [$social])
                        ]) }}

                        {{ Field::text(trans('cms::app.redirect_url'), "socialites[{$social}][redirect_url]", [
                            'disabled' => true,
                            'value' => route('auth.socialites.redirect', [$social])
                        ]) }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</form>
