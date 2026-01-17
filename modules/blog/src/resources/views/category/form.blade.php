@extends('core::layouts.admin')

@section('content')
    <form action="{{ $action }}" class="form-ajax" method="post">
        @if($model->exists)
            @method('PUT')
        @endif

        <div class="row">
            <div class="col-md-12">
                <a href="{{ admin_url('post-categories') }}" class="btn btn-warning">
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
                        <h3 class="card-title">{{ __('core::translation.categories') }}</h3>
                    </div>
                    <div class="card-body">
                        {!! Field::text($model, "name", ['label' => __('core::translation.name'), 'value' => $model->name]) !!}

                        {!! Field::textarea($model, "description", ['label' => __('core::translation.description'), 'value' => $model->description]) !!}

                    </div>
                </div>

            </div>

            <div class="col-md-3">
                <x-language-card :label="$model" :locale="$locale" />

                <div class="card">
                    <div class="card-body">
                        {{ Field::select($model, 'parent_id', ['label' => __('core::translation.parent')])
                           ->classes('select2-input')
                           ->dropDownList(
                               [
                                   '' => __('core::translation.select_parent'),
                                   ...$parentCategories,
                               ]
                           ) }}
                    </div>
                </div>

            </div>
        </div>
    </form>
@endsection

@section('scripts')

@endsection
