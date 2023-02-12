@extends('cms::layouts.backend')

@section('content')
    @component('cms::components.form_resource', [
        'model' => $model,
    ])

        @if($setting->get('fields'))
            @include('cms::backend.resource.components.custom_form')
        @else
            @include('cms::backend.resource.components.default_form')
        @endif

    @endcomponent

@endsection
