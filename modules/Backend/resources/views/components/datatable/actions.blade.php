<div class="dropdown mb-2 mr-2">
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        {{ trans('cms::app.actions') }}
    </button>
    <div class="dropdown-menu" role="menu">
        @foreach($resourses as $key => $resourse)
        <a class="dropdown-item" href="{{ route(
            'admin.post_resource.index',
            [
                $key,
                $row->id
            ]
        ) }}">{{ $resourse->get('label_action') }}</a>
        @endforeach
    </div>
</div>