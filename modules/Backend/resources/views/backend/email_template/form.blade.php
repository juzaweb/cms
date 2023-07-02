@extends('cms::layouts.backend')

@section('content')
    @component('cms::components.form_resource', [
            'action' => $model->code ? route('admin.email-template.update', [$model->code]) : route('admin.email-template.store'),
            'method' => $model->code ? 'put' : 'post'
        ])

        <div class="row">
            <div class="col-md-12">
                @component('cms::components.form_input', [
                    'label' => trans('cms::app.code'),
                    'name' => 'code',
                    'value' => $model->code,
                    'required' => true,
                    'readonly' => (bool) $model->code
                ])
                @endcomponent

                @component('cms::components.form_input', [
                    'label' => trans('cms::app.subject'),
                    'name' => 'subject',
                    'value' => $model->subject,
                    'required' => true
                ])
                @endcomponent

                @component('cms::components.form_ckeditor', [
                    'label' => trans('cms::app.body'),
                    'name' => 'body',
                    'id' => 'body',
                    'value' => $model->body
                ])
                @endcomponent
            </div>
        </div>
    @endcomponent
@endsection
