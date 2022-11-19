@extends('cms::layouts.backend')

@section('content')
    <div class="row mt-4 mb-3">
        <div class="col-md-8">
            <form action="{{ route('admin.theme.setting') }}" method="post" class="form-ajax">
                <h4>{{ trans('cms::app.media_setting.thumbnail_settings') }}</h4>

                @foreach($postTypes as $key => $postType)
                    <h5>{{ $postType->get('label') }}</h5>
                    <label>{{ trans('cms::app.media_setting.thumbnail_size') }}</label>
                    @php
                    $thumbnailSize = get_thumbnail_size($key, $thumbnailSizes ?? []);
                    @endphp
                    <div class="row">
                        <div class="col-md-6">
                            {{ Field::text(
                                trans('cms::app.media_setting.max_width'),
                                 "theme[thumbnail_sizes][{$key}][width]",
                                 [
                                     'value' => $thumbnailSize['width'],
                                 ]
                            ) }}
                        </div>
                        <div class="col-md-6">
                            {{ Field::text(
                                trans('cms::app.media_setting.max_height'),
                                 "theme[thumbnail_sizes][{$key}][height]",
                                 [
                                     'value' => $thumbnailSize['height'],
                                 ]
                            ) }}
                        </div>
                    </div>

                    {{ Field::checkbox(
                            trans('cms::app.media_setting.auto_resize_thumbnail'),
                            "config[auto_resize_thumbnail][{$key}]",
                            [
                                'checked' => get_config('auto_resize_thumbnail', [])[$key] ?? false,
                            ]
                       )
                    }}

                    {{ Field::image(
                        trans('cms::app.media_setting.thumbnail_default'),
                        "config[thumbnail_defaults][{$key}]",
                        [
                            'value' => $thumbnailDefaults[$key] ?? null
                        ]
                    ) }}
                @endforeach

                <button type="submit" class="btn btn-success">
                    <i class="fa fa-save"></i>
                    {{ trans('cms::app.save_change') }}
                </button>
            </form>
        </div>
    </div>
@endsection
