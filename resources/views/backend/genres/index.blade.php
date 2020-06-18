@extends('layouts.backend')

@section('content')
<div class="cui__breadcrumbs">
    <div class="cui__breadcrumbs__path">
        <a href="{{ route('admin.dashboard') }}">@lang('app.home')</a>
        <span>
            <span class="cui__breadcrumbs__arrow"></span>
            <span>App</span>
        </span>
        <span>
            <span class="cui__breadcrumbs__arrow"></span>
            <strong class="cui__breadcrumbs__current">Welcome to Clean UI Pro</strong>
        </span>
    </div>
</div>

<div class="cui__utils__content">
    <div class="air__utils__heading">
        <h5>Form Examples</h5>
    </div>
    <div class="card">
        <div class="card-body">
            <h4 class="mb-4">
                <strong>Basic Form</strong>
            </h4>

            @livewire('genres-form')
        </div>
    </div>

</div>
@endsection