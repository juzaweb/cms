@extends('mymo_core::layouts.backend')

@section('content')

    @component('mymo_core::components.form_resource', [
        'method' => $model->id ? 'put' : 'post',
        'action' =>  $model->id ?
            route('admin.posts.update', [$model->id]) :
            route('admin.posts.store')
    ])
        <div class="row">
            <div class="col-md-8">

                <div class="form-group">
                    <label class="col-form-label" for="title">@lang('mymo_core::app.title')</label>
                    <input type="text" name="title" class="form-control" id="title" value="{{ $model->title }}" autocomplete="off" required>
                </div>

                @include('mymo_core::components.form_ckeditor', [
                    'name' => 'content',
                    'value' => $model->content,
                ])

                @component('mymo_core::components.form_select', [
                    'label' => trans('mymo_core::app.status'),
                    'name' => 'status',
                    'value' => $model->status,
                    'options' => [
                        'public' => trans('mymo_core::app.public'),
                        'private' => trans('mymo_core::app.private'),
                        'draft' => trans('mymo_core::app.draft'),
                    ],
                ])
                @endcomponent

                @do_action('post_type.'. $postType .'.form.left')
                {{--@include('mymo_core::backend.seo_form')--}}
            </div>

            <div class="col-md-4">
                @component('mymo_core::components.form_image', [
                    'label' => trans('mymo_core::app.thumbnail'),
                    'name' => 'thumbnail',
                    'value' => $model->thumbnail,
                ])@endcomponent

                @do_action('post_type.'. $postType .'.form.rigth', $model)
            </div>
        </div>
    @endcomponent

@endsection
