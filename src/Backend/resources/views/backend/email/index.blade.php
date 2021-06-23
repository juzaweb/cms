@extends('mymo::layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-7">
            <h5>@lang('mymo::app.setting')</h5>

            @component('mymo::components.form', [
                'method' => 'post'
            ])

                @component('mymo::components.form_input', [
                    'label' => trans('mymo::app.email_host'),
                    'name' => 'email[host]',
                    'value' => $config['host'] ?? '',
                ])@endcomponent

                <div class="row">
                    <div class="col-md-6">
                        @component('mymo::components.form_input', [
                            'label' => trans('mymo::app.email_port'),
                            'name' => 'email[port]',
                            'value' => $config['port'] ?? '',
                        ])@endcomponent
                    </div>
                    <div class="col-md-6">
                        @component('mymo::components.form_select', [
                            'label' => trans('mymo::app.email_encryption'),
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

                @component('mymo::components.form_input', [
                    'label' => trans('mymo::app.email_username'),
                    'name' => 'email[username]',
                    'value' => $config['username'] ?? '',
                ])@endcomponent

                @component('mymo::components.form_input', [
                    'label' => trans('mymo::app.email_password'),
                    'name' => 'email[password]',
                    'value' => $config['password'] ?? '',
                ])@endcomponent

                <hr>

                @component('mymo::components.form_input', [
                    'label' => trans('mymo::app.email_from_address'),
                    'name' => 'email[from_address]',
                    'value' => $config['from_address'] ?? '',
                ])@endcomponent

                @component('mymo::components.form_input', [
                    'label' => trans('mymo::app.email_from_name'),
                    'name' => 'email[from_name]',
                    'value' => $config['from_name'] ?? '',
                ])@endcomponent

                <div class="mt-3">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> @lang('mymo::app.save')
                    </button>
                </div>
            @endcomponent

        </div>

        <div class="col-md-5">
            <h5>@lang('mymo::app.send_email_test')</h5>

            @component('mymo::components.form', [
                'method' => 'post',
                'action' => route('admin.email.test-email')
            ])
                @component('mymo::components.form_input', [
                    'label' => trans('mymo::app.email'),
                    'name' => 'email',
                    'required' => true,
                ])@endcomponent

                <button type="submit" class="btn btn-success">
                    <i class="fa fa-send"></i>
                    @lang('mymo::app.send_email_test')
                </button>
            @endcomponent
        </div>
    </div>
@endsection
