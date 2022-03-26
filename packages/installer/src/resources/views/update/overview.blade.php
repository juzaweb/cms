@extends('installer::layouts.master-update')

@section('title', trans('installer::updater.welcome.title'))
@section('container')
    <p class="paragraph text-center">{{ trans_choice('message.updater.overview.message', $numberOfUpdatesPending, ['number' => $numberOfUpdatesPending]) }}</p>
    <div class="buttons">
        <a href="{{ route('LaravelUpdater::database') }}" class="button">{{ trans('installer::updater.overview.install_updates') }}</a>
    </div>
@stop
