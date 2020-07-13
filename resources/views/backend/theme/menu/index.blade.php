@extends('layouts.backend')

@section('title', trans('main.menu'))

@section('content')


    <div class="row mt-5">
        <div class="col-md-5">
            @include('backend.theme.menu.form_left')
        </div>

        <div class="col-md-7">
            @include('backend.theme.menu.form_right')
        </div>
    </div>

@endsection