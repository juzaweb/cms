<div class="card p-3">
    <div class="d-flex flex-row mb-3">
        <img src="{{ $item->getThumbnail() }}" width="70" height="70">
        <div class="d-flex flex-column ml-2">
            <span>{{ $item->title }}</span>
            {{--<span class="text-black-50">Payment Services</span>--}}

            <span class="ratings text-secondary">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
            </span>
        </div>
    </div>
    <h6>{{ $item->description }}</h6>
    <div class="d-flex justify-content-between install mt-3">
        {{--<span>Installed 172 times</span>--}}
        @if(!in_array($item->code, $installed))
            <button
                    class="btn btn-primary install-plugin"
                    data-plugin="{{ $item->code }}">
                {{ trans('cms::app.install') }}
            </button>
        @else
            <button class="btn btn-primary" disabled>
                {{ trans('cms::app.installed') }}
            </button>
        @endif

        <a target="_blank" href="{{ $item->url }}" class="text-primary">
            {{ trans('cms::app.view') }}&nbsp;<i class="fa fa-angle-right"></i>
        </a>
    </div>
</div>