@extends('installer::layouts.master')

@section('template_title')
    {{ trans('installer::installer_messages.final.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-flag-checkered fa-fw" aria-hidden="true"></i>
    {{ trans('installer::installer_messages.final.title') }}
@endsection

@section('container')

	@if($result = session('message'))
		@if($result['status'] == 'error')
            <div class="alert error-alert">
                <i class="fa fa-times" aria-hidden="true"></i>
                {{ $result['message'] }}
            </div>
        @endif

        @if($result['status'] == 'success')
            <div class="alert success-alert">
                <i class="fa fa-check" aria-hidden="true"></i>
                {{ $result['message'] }}
            </div>
        @endif
	@endif

    <form method="post" action="{{ route('Installer::environmentSaveWizard') }}" class="tabs-wrap" autocomplete="off">
        @csrf

        <div class="form-group {{ $errors->has('email') ? ' has-error ' : '' }}">
            <label for="email">
                {{ trans('installer::installer_messages.environment.wizard.form.db_host_label') }}
            </label>
            <input type="text" name="email" id="email" value="127.0.0.1" placeholder="{{ trans('installer::installer_messages.environment.wizard.form.db_host_placeholder') }}" autocomplete="off" />
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
