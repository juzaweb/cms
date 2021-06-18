@extends('installer::layouts.master')

@section('template_title')
    {{ trans('installer::installer_messages.final.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-flag-checkered fa-fw" aria-hidden="true"></i>
    {{ trans('installer::installer_messages.final.title') }}
@endsection

@section('container')

    <div class="buttons">
        <a href="{{ url(config('mymo_core.admin_prefix')) }}" class="button" data-turbolinks="false">{{ trans('installer::installer_messages.final.exit') }}</a>
    </div>

@endsection
