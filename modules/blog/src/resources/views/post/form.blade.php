@extends('core::layouts.admin')

@section('content')
    <style>
        .scrollable-list {
            max-height: 350px;
            overflow-y: auto;
            padding-right: 6px;
        }

        .scrollable-list::-webkit-scrollbar {
            width: 6px;
        }

        .scrollable-list::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.3);
            border-radius: 3px;
        }
    </style>

    <form action="{{ $action }}" class="form-ajax" method="post">
        @if($model->exists)
            @method('PUT')
        @endif

        <div class="row">
            <div class="col-md-12">
                <a href="{{ admin_url('posts') }}" class="btn btn-warning">
                    <i class="fas fa-arrow-left"></i> {{ __('core::translation.back') }}
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> {{ __('core::translation.save') }}
                </button>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('core::translation.posts') }}</h3>
                    </div>
                    <div class="card-body">
                        {!! Field::text($model, "title", ['label' => __('core::translation.title'), 'value' => $model->title]) !!}

                        {!! Field::editor($model, "content", ['label' => __('core::translation.content'), 'value' => $model->content]) !!}

                        {{ Field::tags(__('core::translation.tags'), 'tags[]', ['value' => $model->tags->pluck('id')->toArray()])
                           ->dataUrl(load_data_url(\Juzaweb\Modules\Core\Models\Tag::class))
                           ->placeholder(__('core::translation.select_or_add_new_tag'))
                           ->dropDownList(
                               $model->tags->pluck('name', 'id')->toArray()
                           ) }}

                    </div>
                </div>

                {{-- <x-seo-meta :model="$model" :locale="$locale" /> --}}
            </div>

            <div class="col-md-3">
                <x-language-card :label="$model" :locale="$locale"/>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('core::translation.status') }}</h3>
                    </div>
                    <div class="card-body">
                        {!! Field::select($model, 'status', ['label' => __('core::translation.status'), 'value' => $model->status?->value])
                            ->dropDownList(\Juzaweb\Modules\Core\Enums\PostStatus::all()) !!}
                    </div>
                </div>

                <x-card title="{{ __('core::translation.categories') }}">
                    <div class="scrollable-list">
                        @component('core::components.categories-checkbox', [
                                'categories' => $categories,
                                'selectedCategories' => $model->categories->pluck('id')->toArray(),
                                'level' => 0,
                                'showQuickAdd' => true,
                                'storeUrl' => admin_url('post-categories/quick-store'),
                                'locale' => $locale
                            ])
                        @endcomponent
                    </div>
                </x-card>

                <div class="card">
                    <div class="card-body">
                        {{ Field::image(__('core::translation.thumbnail'), 'thumbnail', ['value' => $model->thumbnail]) }}
                    </div>
                </div>

            </div>
        </div>
    </form>
@endsection


