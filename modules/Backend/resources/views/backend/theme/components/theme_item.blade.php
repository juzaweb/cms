<div class="card">
    <div class="height-200 d-flex flex-column jw__g13__head">
        <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="{{ $theme->screenshot }}" alt="{{ $theme->title }}" class="lazyload w-100 h-100">
    </div>

    <div class="card card-bottom card-borderless mb-0">
        <div class="card-header border-bottom-0">
            <div class="d-flex">
                <div class="text-dark text-uppercase font-weight-bold mr-auto">
                    {{ $theme->title }}
                </div>
                <div class="text-gray-6">
                    @if(!$network)
                    <button class="btn btn-primary active-theme" data-theme="{{ $theme->name }}"> {{ trans('cms::app.activate') }}</button>
                    @endif

                    @if (config('juzaweb.theme.enable_upload') && $theme->update)
                    <button class="btn btn-success update-theme" data-theme="{{ $theme->name }}"> {{ trans('cms::app.update') }}</button>
                    @endif

                    @if(config('juzaweb.theme.enable_upload'))
                        <a href="javascript:void(0)" class="delete-theme text-danger" data-theme="{{ $theme->name }}">
                            {{ trans('cms::app.delete') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
