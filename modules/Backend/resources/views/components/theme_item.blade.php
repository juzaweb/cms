<div class="card">
    <div class="height-200 d-flex flex-column jw__g13__head" style="background-image: url('{{ $item->getThumbnail() }}')">
    </div>

    <div class="card card-borderless mb-0">
        <div class="card-header border-bottom-0">
            <div class="d-flex">
                <div class="text-dark text-uppercase font-weight-bold mr-auto">
                    {{ $item->title }}
                </div>

                <div class="text-gray-6">
                    @if(!in_array($item->code, $installed))
                    <button class="btn btn-primary install-theme" data-theme="{{ $item->code }}"><i class="fa fa-check"></i> {{ trans('cms::app.install') }}</button>
                    @else
                        <button class="btn btn-primary" disabled>
                            {{ trans('cms::app.installed') }}
                        </button>
                    @endif
                    {{--<a href="javascript:void(0)" class="text-danger">{{ trans('cms::app.delete') }}</a>--}}
                </div>
            </div>
        </div>
    </div>
</div>
