@foreach($data as $key => $item)
    @php
    $block = $blocks[$item['block']] ?? null;
    @endphp

    @if($block)

    {!! $block['view']->show(array_merge($item, ['key' => $key])) !!}

    @endif
@endforeach
