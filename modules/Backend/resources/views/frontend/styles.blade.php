@foreach ($styles as $style)
    @php
        $href = $style->get('src') .'?v='. $style->get('ver');
    @endphp
    <link rel="stylesheet" type="text/css" href="{{ $href }}" id="css-{{ $style->get('key') }}">
@endforeach

@foreach ($scripts as $script)
    @php
        $href = $script->get('src') .'?v='. $script->get('ver');
    @endphp

    <script src="{{ $href }}" id="js-{{ $script->get('key') }}"></script>
@endforeach

