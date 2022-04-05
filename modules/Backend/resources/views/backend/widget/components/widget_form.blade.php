@foreach($data['form'] ?? [] as $input)
    @php
        $input['data']['value'] = $value[$input['name']] ?? null;
        $input['name'] = "content[{$key}][{$input['name']}]";
    @endphp

    {{ Field::fieldByType($input) }}

@endforeach