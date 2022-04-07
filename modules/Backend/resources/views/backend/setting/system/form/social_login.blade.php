<form method="post" action="{{ route('admin.setting.save') }}" class="form-ajax">
    <input type="hidden" name="form" value="social-login">

    <div class="row mb-3">
        <div class="col-md-8"></div>
        <div class="col-md-4 text-right">
            <button type="submit" class="btn btn-success">
                <i class="fa fa-save"></i> {{ trans('cms::app.save') }}
            </button>
        </div>
    </div>

    <div class="row">
        @foreach($socials as $social)
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>{{ trans("cms::app.socials.{$social}") }}</h5>

                    {{ Field::checkbox(trans('cms::app.enable'), "socialites[{$social}][enable]", [
                        'value' => '1',
                        'checked' => $data[$social]['enable'] ?? false
                    ]) }}

                    {{ Field::text(trans('cms::app.client_id'), "socialites[{$social}][client_id]", [
                        'value' => $data[$social]['client_id'] ?? ''
                    ]) }}

                    {{ Field::text(trans('cms::app.client_secret'), "socialites[{$social}][client_secret]", [
                        'value' => $data[$social]['client_secret'] ?? ''
                    ]) }}

                    {{ Field::text(trans('cms::app.redirect_url'), "socialites[{$social}][redirect_url]", [
                        'disabled' => true,
                        'value' => route('auth.socialites.redirect', [$social])
                    ]) }}
                </div>
            </div>
        </div>
        @endforeach
    </div>
</form>
