@extends('mymo_core::layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-7">
            <h5>@lang('mymo_core::app.setting')</h5>

            @component('mymo_core::components.form', [
                'method' => 'post'
            ])

                @component('mymo_core::components.form_input', [
                    'label' => trans('mymo_core::app.email_host'),
                    'name' => 'email[host]',
                    'value' => $config['host'] ?? '',
                ])@endcomponent

                <div class="row">
                    <div class="col-md-6">
                        @component('mymo_core::components.form_input', [
                            'label' => trans('mymo_core::app.email_port'),
                            'name' => 'email[port]',
                            'value' => $config['port'] ?? '',
                        ])@endcomponent
                    </div>
                    <div class="col-md-6">
                        @component('mymo_core::components.form_select', [
                            'label' => trans('mymo_core::app.email_encryption'),
                            'name' => 'email[encryption]',
                            'value' => $config['encryption'] ?? '',
                            'options' => [
                                '' => 'none',
                                'tls' => 'tls',
                                'ssl' => 'ssl'
                            ],
                        ])@endcomponent
                    </div>
                </div>

                @component('mymo_core::components.form_input', [
                    'label' => trans('mymo_core::app.email_username'),
                    'name' => 'email[username]',
                    'value' => $config['username'] ?? '',
                ])@endcomponent

                @component('mymo_core::components.form_input', [
                    'label' => trans('mymo_core::app.email_password'),
                    'name' => 'email[password]',
                    'value' => $config['password'] ?? '',
                ])@endcomponent

                <hr>

                @component('mymo_core::components.form_input', [
                    'label' => trans('mymo_core::app.email_from_address'),
                    'name' => 'email[from_address]',
                    'value' => $config['from_address'] ?? '',
                ])@endcomponent

                @component('mymo_core::components.form_input', [
                    'label' => trans('mymo_core::app.email_from_name'),
                    'name' => 'email[from_name]',
                    'value' => $config['from_name'] ?? '',
                ])@endcomponent

                <div class="mt-3">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> @lang('mymo_core::app.save')
                    </button>
                </div>
            @endcomponent

        </div>

        <div class="col-md-5">
            <h5>@lang('mymo_core::app.send_email_test')</h5>

            @component('mymo_core::components.form', [
                'method' => 'post',
                'action' => route('admin.email.test-email')
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
    </div>
@endsection
