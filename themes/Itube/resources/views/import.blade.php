@extends('itube::layouts.main')

@section('title', __('itube::translation.import_video'))

@section('head')
    <style>
        .full-height {
            min-height: 80vh;
        }
    </style>
@endsection

@section('content')
    <div class="container full-height d-flex justify-content-center align-items-start mt-5">
        <div class="text-center w-100" style="max-width: 600px;">
            <h1 class="mb-4">Import Video</h1>

            <form method="post" class="d-flex w-100">
                @csrf
                <input type="text" name="url" class="form-control mr-2 flex-grow-1" placeholder="@lang('Enter URL')">
                <button type="submit" class="btn btn-primary">@lang('Import')</button>
            </form>

            <small class="text-muted">Support YouTube, Dailymotion</small>
        </div>
    </div>
@endsection
