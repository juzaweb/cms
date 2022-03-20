<h5>Store Address</h5>
<em>This is where your business is located. Tax rates and shipping rates will use this address.</em>

<div class="row">
    <div class="col-md-12">
        {{ Field::text('Store Address 1', 'ecom_store_address1', [
            'value' => get_config('ecom_store_address1'),
        ]) }}

        {{ Field::text('Store Address 2', 'ecom_store_address2', [
            'value' => get_config('ecom_store_address2'),
        ]) }}

        {{ Field::text('City', 'ecom_city', [
            'value' => get_config('ecom_city'),
        ]) }}

        {{ Field::select('Country / State', 'ecom_city', [
            'value' => get_config('ecom_country'),
            'class' => 'load-countries',
        ]) }}

        {{ Field::text('Postcode / ZIP', 'ecom_city', [
            'value' => get_config('ecom_zipcode'),
        ]) }}
    </div>
</div>

<h5>General options</h5>
<div class="row">
    <div class="col-md-12">
        {{ Field::select('Selling location(s)', 'ecom_selling_locations', [
            'value' => get_config('ecom_selling_locations'),
            'options' => [
                'all' => 'Sell to all countries',
                'all_except' => 'Sell to all countries, except for...',
                'specific' => 'Sell to specific countries',
            ]
        ]) }}

        {{ Field::select('Shipping location(s)', 'ecom_shipping_locations', [
            'value' => get_config('ecom_shipping_locations'),
            'options' => [
                'all' => 'Ship to all countries',
                'all_except' => 'Ship to all countries, except for...',
                'specific' => 'Ship to specific countries',
            ]
        ]) }}
    </div>
</div>

<h5>Currency options</h5>
<em>The following options affect how prices are displayed on the frontend.</em>

<div class="row">
    <div class="col-md-12">
        {{ Field::select('Currency', 'ecom_currency', [
            'value' => get_config('ecom_currency'),
        ]) }}

        {{ Field::select('Currency position', 'ecom_currency', [
            'value' => get_config('ecom_currency'),
        ]) }}

        {{ Field::text('Thousand separator', 'ecom_thousand_separator', [
            'value' => get_config('ecom_thousand_separator'),
        ]) }}

        {{ Field::text('Decimal separator', 'ecom_decimal_separator', [
            'value' => get_config('ecom_decimal_separator'),
        ]) }}

        {{ Field::text('Number of decimals', 'ecom_number_of_decimals', [
            'value' => get_config('ecom_number_of_decimals'),
        ]) }}
    </div>
</div>
