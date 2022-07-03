<div class="card">
    <div class="height-200 d-flex flex-column jw__g13__head" style="background-image: url('{{ $theme->screenshot }}')">
    </div>

    <div class="card card-borderless mb-0">
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

                    <a href="javascript:void(0)" class="delete-theme text-danger" data-theme="{{ $theme->name }}">{{ trans('cms::app.delete') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
