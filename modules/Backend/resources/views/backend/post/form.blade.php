@extends('cms::layouts.editor')

@section('buttons')
    <div class="btn-group">
        <button type="submit" class="btn btn-success px-5">
            <i class="fa fa-save"></i> {{ trans('cms::app.save') }}
        </button>

        <button type="button" class="btn btn-warning cancel-button px-3">
            <i class="fa fa-refresh"></i> {{ trans('cms::app.reset') }}
        </button>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-9">
            @component('cms::components.card', [
                'label' => trans('cms::app.information')
            ])
                <div class="row mb-2">
                    <div class="col-md-12">
                        {{ Field::text($model, 'title', [
                            'required' => true,
                            'class' => empty($model->slug) ? 'generate-slug' : '',
                        ]) }}
                    </div>
                </div>

                @include($editor)

            @endcomponent

            @php
                /** @var \Illuminate\Support\Collection $setting */
                $metas = collect_metas($setting->get('metas'))
                            ->where('sidebar', false)
                            ->where('visible', true)
                            ->toArray();
            @endphp

            @foreach($metas as $name => $meta)
                @php
                    $meta['name'] = "meta[{$name}]";
                    $meta['data']['value'] = $model->getMeta($name);
                @endphp

                {{ Field::fieldByType($meta) }}
            @endforeach

            {{ Field::render($setting->get('fields', []), $model) }}

                @do_action('post_type.'. $postType .'.form.left', $model)

                @do_action('post_types.form.left', $model)
        </div>

        <div class="col-md-3">

            @component('cms::components.card', [
                'label' => trans('cms::app.status')
            ])
                {{ Field::select($model, 'status', [
                    'options' => $model->getStatuses()
                ]) }}
            @endcomponent

            {{ Field::image($model, 'thumbnail') }}

            @php
                $metas = collect_metas($setting->get('metas'))
                    ->where('sidebar', true)
                    ->where('visible', true)
                    ->toArray();
            @endphp

            @foreach($metas as $name => $meta)
                @php
                    $meta['name'] = "meta[{$name}]";
                    $meta['data']['value'] = $model->getMeta($name);
                @endphp

                {{ Field::fieldByType($meta) }}

            @endforeach

            {{ Field::slug($model, 'slug') }}

            @do_action('post_types.form.right', $model)

            @do_action('post_type.'. $postType .'.form.right', $model)
        </div>
    </div>
@endsection
