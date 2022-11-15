<div class="row">
    @php
        $collection = collect_metas($setting->get('fields'));
        $sidebars = $collection->where('sidebar', true)->toArray();
    @endphp

    <div class="col-md-{{ $sidebars ? '8' : '12' }}">
        @php
            $metas = $collection->where('sidebar', false)->toArray();
        @endphp

        {{ Field::render($metas, $model, true) }}

        @php
            $metas = collect_metas($setting->get('metas'))
                        ->where('sidebar', false)
                        ->map(
                            function ($item, $name) use ($model) {
                                $item['name'] = "meta[{$name}]";
                                $item['data']['value'] = $model->getMeta($name);
                            }
                        )
                        ->toArray();
        @endphp

        {{ Field::render($metas, $model, true) }}

        @do_action("resource.{$setting->get('key')}.form_left", $model)
    </div>

    @if($sidebars)
    <div class="col-md-4">
        {{ Field::render($sidebars, $model, true) }}

        @php
            $metas = collect_metas($setting->get('metas'))
                        ->where('sidebar', true)
                        ->map(
                            function ($item, $name) use ($model) {
                                $item['name'] = "meta[{$name}]";
                                $item['data']['value'] = $model->getMeta($name);
                            }
                        )
                        ->toArray();
        @endphp

        {{ Field::render($metas, $model, true) }}

        @do_action("resource.{$setting->get('key')}.form_right", $model)
    </div>
    @endif

</div>
