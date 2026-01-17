@foreach($nextVideos as $nextVideo)
    @component('itube::components.video-sidebar-item', ['video' => $nextVideo])
    @endcomponent
@endforeach