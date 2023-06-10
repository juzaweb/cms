@foreach($fields as $name => $meta)
    @php
        $meta['name'] = Arr::get($meta, 'name', $name);
        if (Arr::has($meta, 'value')) {
            $meta['data']['value'] = Arr::get($meta, 'value');
        } else {
            if (is_array($values)) {
                $meta['data']['value'] = $values[$meta['name']] ?? null;
            } else {
                $meta['data']['value'] = $values->{$meta['name']} ?? null;
            }
        }
    @endphp

    @if(in_array($meta['type'], ['row', 'col']))
        {{ Field::{$meta['type']}($meta, $values) }}
    @else
        {{ Field::fieldByType($meta) }}
    @endif
@endforeach
