<div class="row">
    <div class="col-md-8">

        {{ Field::text($model, 'code', [
            'disabled' => true
        ]) }}

        {{ Field::text($model, 'name', [
            'disabled' => true
        ]) }}

        {{ Field::text($model, 'phone', [
            'disabled' => true
        ]) }}

        {{ Field::text($model, 'email', [
            'disabled' => true
        ]) }}

        {{ Field::text($model, 'address', [
            'disabled' => true
        ]) }}

        {{ Field::textarea($model, 'other_address', [
            'disabled' => true
        ]) }}

        {{ Field::text($model, 'notes') }}
    </div>

    <div class="col-md-4">
        {{ Field::text($model, 'payment_method_id') }}
    </div>
</div>