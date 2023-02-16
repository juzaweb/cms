<div class="row">
    <div class="col-md-8">
        {{ Field::text($model, 'name', [
            'required' => true,
        ]) }}

        @if($setting->get('has_description', true))
        {{ Field::textarea($model, 'description') }}
        @endif

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
        @if(method_exists($model, 'getStatuses'))
        {{ Field::select($model, 'status', [
            'options' => $model->getStatuses()
        ]) }}
        @endif

        @if($setting->get('has_display_order', true))
        {{ Field::text($model, 'display_order', [
            'required' => true,
            'default' => 1
        ]) }}
            @endif

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
