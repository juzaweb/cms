@extends('cms::layouts.backend')

@section('content')
    @component('cms::components.form_resource', [
        'action' => $linkAction,
        'method' => 'post'
    ])

        <div class="row">
            <div class="col-md-12">
                @include('crawler::component.form.component')

                @include('crawler::component.form.remove')

                @include('crawler::component.form.leech')
            </div>
        </div>

        <input type="hidden" name="id" value="{{ $model->id }}">

    @endcomponent
@endsection
