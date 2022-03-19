@extends('cms::layouts.backend')

@section('content')
    <form action="{{ route('admin.setting.save') }}" class="form-ajax">
        @component('cms::components.tabs', [
            'tabs' => [
                'general' => trans('cms::app.general')
            ]
        ])
            @slot('tab_general')
                @include('ecom::backend.setting.components.setting.general')
            @endslot
        @endcomponent

        <button type="submit" class="btn btn-success">Save Changes</button>
    </form>
@endsection