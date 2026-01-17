@extends('itube::layouts.main')

@section('title', __('itube::translation.edit_video'))

@section('head')
    <link rel="stylesheet" href="{{ mix('css/profile.min.css', 'themes/itube') }}">
@endsection

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row" id="wrapper">
            @include('itube::profile.components.sidebar')

            <main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
                <h3 class="section-title">
                    <span>{{ __('itube::translation.edit_video') }}</span>
                </h3>

                <section>
                    <form action="{{ route('profile.my_videos.update', [$video->id]) }}" method="post" class="form-ajax">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-12">
                                @if($video->thumbnail)
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('itube::translation.thumbnail') }}</label>
                                        <div>
                                            <img src="{{ $video->thumbnail }}" alt="Thumbnail" class="img-fluid" style="max-width: 320px; max-height: 180px; object-fit: cover;">
                                        </div>
                                    </div>
                                @endif

                                {{ Field::text(__('itube::translation.video_title'), 'title', [
                                    'value' => $video->title,
                                    'required' => true,
                                ]) }}

                                {{ Field::textarea(__('itube::translation.video_description'), 'description', [
                                    'value' => $video->description,
                                    'rows' => 5,
                                ]) }}

                                {{ Field::select(__('itube::translation.mode'), 'mode', [
                                    'value' => $video->mode->value,
                                    'options' => [
                                        'public' => __('itube::translation.public'),
                                        'private' => __('itube::translation.private'),
                                        'unlisted' => __('itube::translation.unlisted'),
                                    ],
                                    'required' => true,
                                ]) }}

                                <div class="mb-3">
                                    <label class="form-label">{{ __('itube::translation.status') }}</label>
                                    <div>
                                        @if($video->status->value === 'pending')
                                            <span class="badge badge-warning">{{ __('itube::translation.pending') }}</span>
                                        @elseif($video->status->value === 'published')
                                            <span class="badge badge-success">{{ __('itube::translation.published') }}</span>
                                        @elseif($video->status->value === 'rejected')
                                            <span class="badge badge-danger">{{ __('itube::translation.rejected') }}</span>
                                        @else
                                            <span class="badge badge-secondary">{{ $video->status->value }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">{{ __('itube::translation.views') }}</label>
                                    <div>{{ number_format($video->views) }}</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">{{ __('itube::translation.created_at') }}</label>
                                    <div>{{ $video->created_at->format('M d, Y h:i A') }}</div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> {{ __('itube::translation.update_video') }}
                            </button>
                            <a href="{{ url('profile/my-videos') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> {{ __('itube::translation.back_to_my_videos') }}
                            </a>
                        </div>
                    </form>
                </section>

                <div class="clearfix"></div>
            </main>

        </div>
    </div>
@endsection
