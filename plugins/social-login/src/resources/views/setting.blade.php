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
                    <h5>{{ trans("juso::content.socials.{$social}") }}</h5>

                    {{ Field::checkbox(trans('juso::content.enable'), "socialites[{$social}][enable]", [
                        'value' => '1',
                        'checked' => $data[$social]['enable'] ?? false
                    ]) }}

                    {{ Field::text(trans('juso::content.client_id'), "socialites[{$social}][client_id]", [
                        'value' => $data[$social]['client_id'] ?? ''
                    ]) }}

                    {{ Field::text(trans('juso::content.client_secret'), "socialites[{$social}][client_secret]", [
                        'value' => $data[$social]['client_secret'] ?? ''
                    ]) }}

                    {{ Field::text(trans('juso::content.redirect_url'), "socialites[{$social}][redirect_url]", [
                        'disabled' => true,
                        'value' => route('auth.socialites.redirect', [$social])
                    ]) }}
                </div>
            </div>
        </div>
        @endforeach
    </div>
</form>
