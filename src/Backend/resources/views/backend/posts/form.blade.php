@extends('mymo::layouts.backend')

@section('content')

    @component('mymo::components.form_resource', [
        'method' => $model->id ? 'put' : 'post',
        'action' =>  $model->id ?
            route('admin.posts.update', [$model->id]) :
            route('admin.posts.store')
    ])
        <div class="row">
            <div class="col-md-8">

                <div class="form-group">
                    <label class="col-form-label" for="title">@lang('mymo::app.title')</label>
                    <input type="text" name="title" class="form-control" id="title" value="{{ $model->title }}" autocomplete="off" required>
                </div>

                @include('mymo::components.form_ckeditor', [
                    'name' => 'content',
                    'value' => $model->content,
                ])

                @component('mymo::components.form_select', [
                    'label' => trans('mymo::app.status'),
                    'name' => 'status',
                    'value' => $model->status,
                    'options' => [
                        'public' => trans('mymo::app.public'),
                        'private' => trans('mymo::app.private'),
                        'draft' => trans('mymo::app.draft'),
                    ],
                ])
                @endcomponent

                @do_action('post_type.'. $postType .'.form.left')
                {{--@include('mymo::backend.seo_form')--}}
            </div>

            <div class="col-md-4">
                @component('mymo::components.form_image', [
                    'label' => trans('mymo::app.thumbnail'),
                    'name' => 'thumbnail',
                    'value' => $model->thumbnail,
                ])@endcomponent

                @do_action('post_type.'. $postType .'.form.rigth', $model)
            </div>
        </div>
    @endcomponent

@endsection
