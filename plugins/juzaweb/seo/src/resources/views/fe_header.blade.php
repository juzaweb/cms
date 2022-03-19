@php
$name = get_config('title');
@endphp
<link rel="alternate" type="application/atom+xml" title="{{ $name }} &raquo; Feed" href="{{ route('feed') }}">

@if($taxonomy)
    <link rel="alternate" type="application/atom+xml" title="{{ $name }} &raquo; Feed" href="{{ route('feed.taxonomy', [$taxonomy]) }}">
@endif

