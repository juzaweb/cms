<form method="post" action="" class="form-ajax">
    @method('put')
    @csrf

    @php
        $languages = array_merge(['' => '------'], $languages ?? []);
        $countries = array_merge(['' => '------'], $countries ?? []);
    @endphp

    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    {{ Field::text($jw_user, 'name') }}
                </div>

                <div class="col-md-12">
                    {{ Field::text($jw_user, 'email', ['disabled' => true]) }}
                </div>

                <div class="col-md-6">
                    {{ Field::text('birthday', 'metas[birthday]', [
                        'value' => $jw_user->getMeta('birthday'),
                        'class' => 'datepicker'
                    ]) }}
                </div>

                <div class="col-md-6">
                    {{ Field::select('country', 'metas[country]', [
                        'value' => $jw_user->getMeta('country'),
                        'options' => $countries
                    ]) }}
                </div>

            </div>
        </div>

        <div class="col-md-4">
            {{ Field::image($jw_user, 'avatar') }}

            {{ Field::select($jw_user, 'language', [
                'options' => $languages
            ]) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="offset-sm-2 col-sm-10">
            <button type="submit" class="btn btn-success">{{ trans('cms::app.update') }}</button>
        </div>
    </div>
</form>
