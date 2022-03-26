@extends('installer::layouts.master-update')

@section('title', trans('installer::updater.welcome.title'))
@section('container')
    <p class="paragraph text-center">
    	{{ trans('installer::updater.welcome.message') }}
    </p>
    <div class="buttons">
        <a href="{{ route('LaravelUpdater::overview') }}" class="button">{{ trans('installer::next') }}</a>
    </div>
@stop
