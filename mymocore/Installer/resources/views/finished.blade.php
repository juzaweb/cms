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



    <div class="buttons">
        <a href="{{ url('/') }}" class="button">{{ trans('installer::installer_messages.final.exit') }}</a>
    </div>

@endsection
