@extends('network::layout')

@section('content')

    @component('cms::components.form_resource', [
        'model' => $model
    ])
        <input type="hidden" name="id" value="{{ $model->id }}">

        <div class="row">
            <div class="col-md-8">
                {{ Field::text($model, 'domain') }}


            </div>

            <div class="col-md-4">
                {{ Field::select($model, 'status', [
                    'options' => $statuses
                ]) }}
            </div>
        </div>
    @endcomponent

@endsection
