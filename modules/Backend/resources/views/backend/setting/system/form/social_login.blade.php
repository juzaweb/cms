<div class="row">
    @foreach($socials as $social)
        <div class="col-md-6">
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
    @endforeach
</div>
