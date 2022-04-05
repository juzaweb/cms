@foreach($data['form'] ?? [] as $input)
    @if($input['type'] == 'container')
        <h5>{{ __($input['label']) }}</h5>
        @foreach($input['children'] ?? [] as $child)
            @php
                $child['data']['value'] = $value[$input['name']][$child['name']] ?? null;
                $child['name'] = "blocks[{$contentKey}][{$key}][{$input['name']}][{$child['name']}]";
            @endphp

            {{ Field::fieldByType($child) }}
        @endforeach
    @else
        @php
            $input['data']['value'] = $value[$input['name']] ?? null;
            $input['name'] = "blocks[{$contentKey}][{$key}][{$input['name']}]";
        @endphp

        {{ Field::fieldByType($input) }}
    @endif

@endforeach