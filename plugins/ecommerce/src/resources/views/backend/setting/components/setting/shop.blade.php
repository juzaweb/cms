<h5>Store Address</h5>
<div class="row">
    <div class="col-md-12">
        {{ Field::select(__('Checkout Page'), 'ecom_checkout_page', [
            'value' => get_config('ecom_checkout_page'),
            'options' => \Juzaweb\Backend\Models\Post::whereType('pages')
                ->get()->mapWithKeys(function ($item) {
                    return [$item->id => $item->title];
                })
                ->toArray(),
        ]) }}

    </div>
</div>

