@extends('juzaweb::installer.layouts.master-update')

@section('title', trans('juzaweb::installer.updater.final.title'))
@section('container')
    <p class="paragraph text-center">{{ session('message')['message'] }}</p>
    <div class="buttons">
        <a href="{{ url('/') }}" class="button">{{ trans('juzaweb::installer.updater.final.exit') }}</a>
    </div>
@stop
