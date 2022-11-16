@extends('cms::layouts.backend')

@section('content')
    <div class="row mt-4 mb-3">
        <div class="col-md-12">
            <form action="{{ route('admin.setting.save') }}" method="post" class="form-ajax">
                <h5 class="card-title">{{ trans('cms::app.thumbnail_defaults') }}</h5>

                @foreach($postTypes as $key => $postType)
                    {{ Field::image(
                        trans($postType->get('label')),
                        "thumbnail_defaults[{$key}]",
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
