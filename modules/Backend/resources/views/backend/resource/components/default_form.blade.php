<div class="row">
    <div class="col-md-8">
        {{ Field::text($model, 'name', [
            'required' => true,
        ]) }}

        {{ Field::textarea($model, 'description') }}

        @php
            $metas = collect_metas($setting->get('metas'))
                        ->where('sidebar', false)
                        ->toArray();
        @endphp

        @foreach($metas as $name => $meta)
            @php
                $meta['name'] = "meta[{$name}]";
                $meta['data']['value'] = $model->getMeta($name);
            @endphp

            {{ Field::fieldByType($meta) }}
        @endforeach

        @do_action("resource.{$setting->get('key')}.form_left", $model)
    </div>

    <div class="col-md-4">
        {{ Field::select($model, 'status', [
            'options' => $model->getStatuses()
        ]) }}

        {{ Field::text($model, 'display_order', [
            'required' => true,
            'default' => 1
        ]) }}

        @php
            $metas = collect_metas($setting->get('metas'))
                        ->where('sidebar', true)
                        ->toArray();
        @endphp

        @foreach($metas as $name => $meta)
            @php
                $meta['name'] = "meta[{$name}]";
                $meta['data']['value'] = $model->getMeta($name);
            @endphp

            {{ Field::fieldByType($meta) }}
        @endforeach

        @do_action("resource.{$setting->get('key')}.form_right", $model)
    </div>
</div>
