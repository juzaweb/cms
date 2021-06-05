@extends('mymo_core::layouts.backend')

@section('content')
    <div class="row">
    <div class="col-md-5">
        <h5>@lang('mymo_core::app.send_email_test')</h5>

        @component('mymo_core::components.form', [
            'method' => 'post'
        ])
            @component('mymo_core::components.form_input', [
                'label' => trans('mymo_core::app.email'),
                'name' => 'email',
                'required' => true,
            ])@endcomponent

            <button type="submit" class="btn btn-success">
                <i class="fa fa-send"></i>
                @lang('mymo_core::app.send_email_test')
            </button>
        @endcomponent
    </div>

    <div class="col-md-7">
        <h5>@lang('mymo_core::app.setting')</h5>

        <form action="" method="post" class="form-ajax">
            @component('mymo_core::components.form_input', [
                'label' => trans('mymo_core::app.email_host'),
                'name' => 'email_host',
            ])@endcomponent

            @component('mymo_core::components.form_input', [
                'label' => trans('mymo_core::app.email_port'),
                'name' => 'email_port',
                'value' => get_config('email_port'),
            ])@endcomponent

            @component('mymo_core::components.form_select', [
                'label' => trans('mymo_core::app.email_encryption'),
                'name' => 'email_encryption',
                'value' => get_config('email_encryption'),
                'options' => [
                    '' => 'none',
                    'tls' => 'tls',
                    'ssl' => 'ssl'
                ],
            ])@endcomponent

            @component('mymo_core::components.form_input', [
                'label' => trans('mymo_core::app.email_username'),
                'name' => 'email_username',
                'value' => get_config('email_username'),
            ])@endcomponent

            @component('mymo_core::components.form_input', [
                'label' => trans('mymo_core::app.email_password'),
                'name' => 'email_password',
                'value' => get_config('email_password'),
            ])@endcomponent

            <hr>

            @component('mymo_core::components.form_input', [
                'label' => trans('mymo_core::app.email_from_address'),
                'name' => 'email_from_address',
                'value' => get_config('email_from_address'),
            ])@endcomponent

            @component('mymo_core::components.form_input', [
                'label' => trans('mymo_core::app.email_from_name'),
                'name' => 'email_from_name',
                'value' => get_config('email_from_name'),
            ])@endcomponent

            <div class="form-group">
                <input type="checkbox" name="email_setting" id="email_setting" value="1" @if(get_config('email_setting', 1)) checked @endif>
                <label for="email_setting">{{ trans('mymo_core::app.email_setting') }}</label>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('mymo_core::app.save')</button>
            </div>
        </form>
    </div>
</div>
@endsection
