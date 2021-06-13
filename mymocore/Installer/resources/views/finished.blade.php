@extends('installer::layouts.master')

@section('template_title')
    {{ trans('installer::installer_messages.final.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-flag-checkered fa-fw" aria-hidden="true"></i>
    {{ trans('installer::installer_messages.final.title') }}
@endsection

@section('container')

    <form method="post" action="{{ route('Installer::environmentSaveWizard') }}" class="tabs-wrap" autocomplete="off">
        @csrf

        <div class="form-group {{ $errors->has('email') ? ' has-error ' : '' }}">
            <label for="email">
                {{ trans('installer::installer_messages.environment.wizard.form.email') }}
            </label>
            <input type="text" name="email" id="email" value="127.0.0.1" placeholder="{{ trans('installer::installer_messages.environment.wizard.form.email') }}" autocomplete="off" />
            @if ($errors->has('email'))
                <span class="error-block">
                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                    {{ $errors->first('email') }}
                </span>
            @endif
        </div>

    </form>

    {{--<div class="buttons">
        <a href="{{ url('/') }}" class="button">{{ trans('installer::installer_messages.final.exit') }}</a>
    </div>--}}

@endsection
