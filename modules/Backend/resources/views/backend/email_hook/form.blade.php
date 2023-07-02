@extends('cms::layouts.backend')

@section('content')
    @component('cms::components.form_resource', [
            'model' => $model
        ])

        <div class="row">
            <div class="col-md-8">

                {{ Field::text($model, 'subject', ['required' => true]) }}

                {{ Field::checkbox($model, 'to_sender', ['checked' => ($model->to_sender ?? 1) == 1, 'description' => trans('cms::app.to_sender_description')]) }}

                {{ Field::selectUser($model, 'to_users', ['multiple' => true, 'options' => $model->users->mapWithKeys(fn($user) => [$user->id => $user->name])->toArray(), 'value' => $model->users->pluck('id')->toArray()]) }}

                {{ Field::editor($model, 'body') }}

            </div>

            <div class="col-md-4">
                {{ Field::select($model, 'email_hook', [
                     'label' => trans('cms::app.email_hook'),
                     'options' => array_merge([
                        '' => trans('cms::app.select', ['name' => trans('cms::app.email_hook')])
                    ], jw_get_select_options($emailHooks))
                ]) }}

                {{ Field::checkbox($model, 'active', ['checked' => ($model->active ?? 1) == 1]) }}
            </div>
        </div>
    @endcomponent
@endsection
