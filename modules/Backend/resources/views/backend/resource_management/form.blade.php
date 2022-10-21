@extends('cms::layouts.backend')

@section('content')
    @component('cms::components.form_resource', [
        'model' => $model,
    ])
        @php
            $collection = collect_metas($setting->get('fields'));
            $sidebars = $collection->where('sidebar', true)->toArray();
        @endphp

        <div class="row">
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

                @do_action("resource_management.{$setting->get('key')}.form_left", $model)
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

                @do_action("resource_management.{$setting->get('key')}.form_right", $model)
            </div>
            @endif
        </div>
    @endcomponent

@endsection
