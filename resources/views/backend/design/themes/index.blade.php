@extends('layouts.backend')

@section('title', trans('app.themes'))

@section('content')
    {{ Breadcrumbs::render('manager', [
            'name' => trans('app.themes'),
            'url' => route('admin.design.themes')
        ]) }}

    <div class="cui__utils__content">

    </div>
@endsection