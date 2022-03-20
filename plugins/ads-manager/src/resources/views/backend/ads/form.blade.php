@extends('cms::layouts.backend')

@section('content')

    @component('cms::components.form_resource', [
        'model' => $model
    ])

        <div class="row">
            <div class="col-md-8">
                {{ Field::text($model, 'name') }}

                {{ Field::editor($model, 'body') }}
            </div>

            <div class="col-md-4">
                {{ Field::select($model, 'active', [
                    'options' => [
                        '1' => trans('cms::app.enabled'),
                        '0' => trans('cms::app.disabled'),
                    ]
                ]) }}

                {{ Field::select($model, 'position', [
                    'options' => $positions
                ]) }}
            </div>
        </div>
    @endcomponent
@endsection
