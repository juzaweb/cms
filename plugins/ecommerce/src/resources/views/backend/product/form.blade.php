<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                {{ Field::text(trans('ecom::content.price'), 'meta[price]', [
                    'value' => $variant->price ? number_format($variant->price) : '',
                    'class' => 'is-number number-format'
                ]) }}
            </div>

            <div class="col-md-6">
                {{ Field::text(trans('ecom::content.compare_price'), 'meta[compare_price]', [
                    'value' => $variant->compare_price ? number_format($variant->compare_price) : '',
                    'class' => 'is-number number-format'
                ]) }}
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                {{ Field::text(trans('ecom::content.sku_code'), 'meta[sku_code]', [
                    'value' => $variant->sku_code ?? '',
                ]) }}
            </div>

            <div class="col-md-6">
                {{ Field::text(trans('ecom::content.barcode'), 'meta[barcode]', [
                    'value' => $variant->barcode ?? '',
                ]) }}
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                {{ Field::checkbox(
                    trans('ecom::content.inventory_management'),
                    'meta[inventory_management]',
                    [
                        'checked' => $model->getMeta('inventory_management') == 1,
                    ]
                ) }}

                {{ Field::text(trans('ecom::content.quantity'), 'meta[quantity]', [
                    'value' => $model->getMeta('quantity') ?? '',
                    'class' => 'is-number number-format'
                ]) }}

                {{ Field::checkbox(
                    trans('ecom::content.allows_ordering_out_of_stock'),
                    'meta[disable_out_of_stock]',
                    [
                        'checked' => $model->getMeta('disable_out_of_stock') == 1,
                    ]
                ) }}
            </div>
        </div>
    </div>
</div>

{{ Field::images(trans('ecom::content.images'), 'meta[images]', [
    'value' => $variant->images ?? [],
]) }}

