@extends('cms::layouts.backend')

@section('content')
    @component('cms::components.form_resource', [
        'model' => $model
    ])

        <input type="hidden" name="id" value="{{ $model->id }}">

        <div class="row">
            <div class="col-md-8">
                @component('cms::components.card', [
                    'label' => trans('cms::app.general')
                ])
                    {{ Field::select($model, 'type', [
                        'disabled' => $model->id ? true : false,
                        'required' => true,
                        'label' => trans('ecom::content.method'),
                        'options' => array_merge(
                            ['' => '--- '.trans('ecom::content.payment_method').' ---'],
                            $methods
                        )
                    ]) }}

                    {{ Field::text($model, 'name', [
                        'required' => true,
                    ]) }}
                @endcomponent

                @component('cms::components.card', [
                    'label' => trans('cms::app.config'),
                    'class' => $model->data ? 'box-data': 'box-hidden box-data'
                ])
                    @if($model->type == 'paypal')
                        @component('ecom::backend.payment_method.components.paypal_template', [
                        'data' => $model->data
                    ])

                        @endcomponent
                    @endif

                    @if($model->type == 'custom')
                        @component('ecom::backend.payment_method.components.custom_template', [
                        'data' => $model->data
                    ])

                        @endcomponent
                    @endif
                @endcomponent
            </div>

            <div class="col-md-4">
                @component('cms::components.card', [
                    'label' => trans('cms::app.status'),
                ])
                    {{ Field::checkbox($model, 'active', [
                        'checked' => $model->active == 1 || is_null($model->active)
                    ]) }}
                @endcomponent
            </div>
        </div>

    @endcomponent

    <template id="data-custom">
        @component('ecom::backend.payment_method.components.custom_template')

        @endcomponent
    </template>

    <template id="data-paypal">
        @component('ecom::backend.payment_method.components.paypal_template')

        @endcomponent
    </template>

    <script type="text/javascript">
        $('select[name=type]').on('change', function () {
            let type = $(this).val();
            let name = $(this).find('option:selected').text().trim();

            if (type && type !== 'custom') {
                $('input[name=name]').val(name);
            } else {
                $('input[name=name]').val('');
            }

            $('.box-data .card-body').empty();
            let template = document.getElementById('data-' + type);
            if (template) {
                template = template.innerHTML;
                $('.box-data .card-body').html(template);
                $('.box-data').show('slow');
            } else {
                $('.box-data').hide();
            }
        });
    </script>

@endsection
