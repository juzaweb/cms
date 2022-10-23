<div class="row">
    @php
        $collection = collect_metas($setting->get('fields'));
        $sidebars = $collection->where('sidebar', true)->toArray();
    @endphp

    <div class="col-md-{{ $sidebars ? '8' : '12' }}">
        @php
            $metas = $collection->where('sidebar', false)->toArray();
        @endphp

        @foreach($metas as $name => $meta)
            @php
                $meta['name'] = $name;
                $meta['data']['value'] = Arr::get($meta, 'value', $model->{$name});
            @endphp

            {{ Field::fieldByType($meta) }}
        @endforeach

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

    @if($sidebars)
    <div class="col-md-4">
        @foreach($sidebars as $name => $meta)
            @php
                $meta['name'] = $name;
                $meta['data']['value'] = Arr::get($meta, 'value', $model->{$name});
            @endphp

            {{ Field::fieldByType($meta) }}
        @endforeach

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
    @endif

</div>
