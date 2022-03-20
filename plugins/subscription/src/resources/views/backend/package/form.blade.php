@extends('cms::layouts.backend')

@section('content')
    @component('cms::components.form_resource', [
        'model' => $model
    ])

        <div class="row">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-body">
                        {{ Field::text($model, 'name', [
                    'required' => true
                ]) }}

                        {{ Field::textarea($model, 'description', [
                            'required' => true
                        ]) }}
                    </div>
                </div>
                @if($configs)
                <div class="card">
                    <div class="card-body">
                        @foreach($configs as $key => $config)
                            {{ Field::text($config['name'], "config[{$key}]", [
                                'value' => $model->getConfig($key)
                            ]) }}
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h5>{{ trans('subr::content.features') }}</h5>
                    </div>

                    <div class="card-body">
                        <div class="row" id="data-list">
                            @php
                                $dataList = empty($model->data) ? [] : $model->data;
                            @endphp
                            @foreach($dataList as $item)
                                @component('subr::backend.package.components.data_item', [
                                    'data' => $item
                                ])
                                @endcomponent
                            @endforeach
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-right">
                                <a href="javascript:void(0)"
                                   class="text-link add-data">
                                    {{ trans('subr::content.add_feature') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                {{
                    Field::select($model, 'status', [
                        'options' => $statuses
                    ])
                }}

                {{
                    Field::select($model, 'module', [
                        'options' => $modules
                    ])
                }}

                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="col-form-label">{{ trans('subr::content.price') }}</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="text" name="price" class="form-control is-number number-format" id="price" value="{{ $model->price ? number_format($model->price, 2) : '' }}" autocomplete="off" @if($model->is_free == 1) disabled @endif>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">/ {{ trans('cms::app.month') }}</span>
                                </div>
                            </div>
                        </div>

                        {{ Field::checkbox($model, 'is_free', [
                            'value' => 1,
                            'checked' => $model->is_free == 1,
                        ]) }}
                    </div>
                </div>

            </div>
        </div>
    @endcomponent

    <template id="data-template">
        @component('subr::backend.package.components.data_item', [
            'data' => null
        ])
        @endcomponent
    </template>

    <script>
        $('form').on('change', 'input[name=is_free]', function () {
            let active = $(this).is(':checked');
            if (active) {
                $('#price').prop('disabled', true);
            } else {
                $('#price').prop('disabled', false);
            }
        });

        $('body').on('click', '.add-data', function () {
            let temp = document.getElementById('data-template').innerHTML;
            $('#data-list').append(temp);
        });
    </script>

@endsection
