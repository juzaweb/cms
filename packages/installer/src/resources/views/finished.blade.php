@extends('juzaweb::installer.layouts.master')

@section('template_title')
    {{ trans('juzaweb::installer.final.template_title') }}
@endsection

@section('title')
    <i class="fa fa-flag-checkered fa-fw" aria-hidden="true"></i>
    {{ trans('juzaweb::installer.final.title') }}
@endsection

@section('container')

    <div class="buttons">
        <a href="{{ url(config('juzaweb.admin_prefix')) }}" class="button" data-turbolinks="false">{{ trans('juzaweb::installer.final.exit') }}</a>
    </div>

@endsection
