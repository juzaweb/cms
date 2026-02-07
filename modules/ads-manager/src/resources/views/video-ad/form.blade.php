@extends('core::layouts.admin')

@section('content')
    <form action="{{ $action }}" class="form-ajax" method="post">
        @if($model->exists)
            @method('PUT')
        @endif

        <div class="row">
            <div class="col-md-12">
                <a href="{{ $backUrl }}" class="btn btn-warning">
                    <i class="fas fa-arrow-left"></i> {{ __('ad-management::translation.back') }}
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> {{ __('ad-management::translation.save') }}
                </button>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-9">
                <x-card title="{{ __('ad-management::translation.information') }}">
                    {{ Field::text(__('ad-management::translation.name'), 'name', ['value' => $model->name])->help('The internal name for the ad.') }}

					{{ Field::text(__('ad-management::translation.title'), 'title', ['value' => $model->title])->help('The title that appears when the ad is displayed.') }}

					{{ Field::uploadUrl(__('ad-management::translation.video'), 'video', ['value' => $model->video])->uploadType('video')->help('Upload the video file for the ad.') }}

					{{ Field::text(__('ad-management::translation.url'), 'url', ['value' => $model->url])->help('The URL to which the user will be redirected when clicking on the ad.') }}

					{{ Field::text(__('ad-management::translation.offset'), 'offset', ['value' => $model->offset ?? 5])->help(__('ad-management::translation.offset_in_seconds_when_the_ad_will_appear_during_video_playback')) }}
                </x-card>
            </div>

            <div class="col-md-3">
                <x-card title="{{ __('ad-management::translation.status') }}">
                    {{ Field::checkbox(__('ad-management::translation.active'), 'active', ['value' => $model->active]) }}
                </x-card>

                <x-card title="{{ __('ad-management::translation.position') }}">
                    {{ Field::select(__('ad-management::translation.position'), 'position', ['value' => $model->position])->dropDownList(
                        collect($positions)
                            ->mapWithKeys(fn($item) => [$item->key => $item->name])
                            ->prepend(__('ad-management::translation.select_position'), '')
                            ->toArray()
                    ) }}
                </x-card>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script type="text/javascript" nonce="{{ csp_script_nonce() }}">
        $(function () {
            //
        });
    </script>
@endsection
