@extends('itube::layouts.main')

@section('title', $channel->name)

@section('head')

@endsection

@section('content')
    <div class="container mb-5">
        <div class="row">
            <div class="col-lg-auto d-none d-xl-block">
                @include('itube::components.sidebar', ['active' => 'home'])
            </div>

            <div class="col-lg">
                <div class="max-w-md-1160 ml-auto my-6">
                    <!-- Info -->
                    <div class="container channel-info">
                        <div class="channel-cover w-100 mb-2">
                            <img src="https://placehold.co/1235x338" alt="Channel Cover" class="img-fluid">
                        </div>

                        <div class="d-flex align-items-center">
                            <img src="https://placehold.co/120" alt="Avatar" class="channel-avatar">
                            <div class="ml-3">
                                <h4 class="mb-0">{{ $channel->name }}</h4>
                                <small class="text-muted">{{ number_human_format($channel->subscribers()->count()) }} {{ __('itube::translation.subscribers') }}</small>
                            </div>
                            <div class="ml-auto">
                                <button class="btn btn-danger">{{ __('itube::translation.subscribe') }}</button>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs -->
                    <div class="container mt-4">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Videos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Playlists</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">About</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Videos -->
                    <div class="container mt-4">
                        <div class="row">
                            @foreach($videos as $video)
                                @component('itube::components.video-item', ['video' => $video])
                                @endcomponent
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
