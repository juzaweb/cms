@extends('cms::installer.layouts.master-update')

@section('title', trans('cms::installer.updater.welcome.title'))
@section('container')
    <p class="paragraph text-center">
    	{{ trans('cms::installer.updater.welcome.message') }}
    </p>
    <div class="buttons">
        <a href="{{ route('LaravelUpdater::overview') }}" class="button">{{ trans('cms::installer.next') }}</a>
    </div>
@stop
