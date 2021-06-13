@extends('installer::layouts.master')

@section('template_title')
    {{ trans('installer::installer_messages.environment.menu.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-cog fa-fw" aria-hidden="true"></i>
    {!! trans('installer::installer_messages.environment.menu.title') !!}
@endsection

@section('container')

    <p class="text-center">
        {!! trans('installer::installer_messages.environment.menu.desc') !!}
    </p>
    <div class="buttons">
        <a href="{{ route('installer::environmentWizard') }}" class="button button-wizard">
            <i class="fa fa-sliders fa-fw" aria-hidden="true"></i> {{ trans('installer::installer_messages.environment.menu.wizard-button') }}
        </a>
        <a href="{{ route('installer::environmentClassic') }}" class="button button-classic">
            <i class="fa fa-code fa-fw" aria-hidden="true"></i> {{ trans('installer::installer_messages.environment.menu.classic-button') }}
        </a>
    </div>

@endsection
