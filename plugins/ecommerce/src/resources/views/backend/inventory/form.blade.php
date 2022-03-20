@extends('cms::layouts.backend')

@section('content')
    @component('cms::components.form_resource', [
        'model' => $model
    ])

        <div class="row">
            <div class="col-md-12">

                {{ Field::text($model, 'variant_id') }}

			    {{ Field::text($model, 'quantity') }}

            </div>
        </div>

    @endcomponent
@endsection
