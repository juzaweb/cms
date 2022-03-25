@extends('juzaweb::installer.layouts.master-update')

@section('title', trans('juzaweb::installer.updater.welcome.title'))
@section('container')
    <p class="paragraph text-center">
    	{{ trans('juzaweb::installer.updater.welcome.message') }}
    </p>
    <div class="buttons">
        <a href="{{ route('LaravelUpdater::overview') }}" class="button">{{ trans('juzaweb::installer.next') }}</a>
    </div>
@stop
