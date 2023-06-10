<div class="card mt-3">
    <div class="card-header row">
        <div class="col-md-6">
            <h4 class="card-title">{{ trans('cms::app.custom_seo') }}</h4>
        </div>

        <div class="col-md-6 text-right">
            <a href="javascript:void(0)" class="custom-seo">
                <i class="fa fa-edit"></i> {{ trans('cms::app.custom_seo') }}
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="box-custom-seo box-hidden">
            <div class="form-group">
                <label for="meta_title" class="form-label">
                    {{ trans('cms::app.title') }}
                </label>
                <input type="text" name="meta_title" id="meta_title" class="form-control" value="{{ $data->meta_title ?? '' }}" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="meta_description" class="form-label">{{ trans('cms::app.description') }}</label>
                <textarea name="meta_description" id="meta_description" class="form-control" rows="4" autocomplete="off">{{ $data->meta_description ?? '' }}</textarea>
            </div>
            <hr>
        </div>

        <div class="seo-review">
            <h5>{{ trans('cms::app.preview') }}</h5>
            <div class="review-title">{{ seo_string($data->meta_title ?? $model->title, 70) }}</div>
            <div class="review-url">{{ url('/post') }}/<span>{{ $model->slug }}</span></div>
            <div class="review-description">{{ seo_string($data->meta_description ?? $model->description, 300) }}</div>
        </div>
    </div>
</div>
