@extends('core::layouts.admin')

@section('content')
    <form action="" method="post" class="form-ajax">
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> {{ __('itech::translation.save_changes') }}
                </button>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-9">
                <x-card title="{{ __('itech::translation.page_settings') }}">
                    @php
                        $homePage = theme_setting('home_page')
                            ? \Juzaweb\Modules\Core\Models\Pages\Page::where('id', theme_setting('home_page'))->first()
                            : null;
                    @endphp

                    {{ Field::select(__('itech::translation.home_page'), 'home_page', ['value' => theme_setting('home_page')])->dropDownList([
                            $homePage?->id ?? '' => $homePage?->title ?? __('itech::translation.select_a_page'),
                        ])->dataUrl(load_data_url(\Juzaweb\Modules\Core\Models\Pages\Page::class, 'title')) }}

                    {{ Field::image(__('itech::translation.footer_logo'), 'footer_logo', ['value' => theme_setting('footer_logo')]) }}

                    {{ Field::textarea(__('itech::translation.footer_description'), 'footer_description', ['value' => theme_setting('footer_description')]) }}
                </x-card>

                <x-card title="{{ __('itech::translation.socials') }}">
                    @foreach ($socials as $social)
                        {{ Field::text(ucfirst($social), "social_{$social}", ['value' => theme_setting("social_{$social}")]) }}
                    @endforeach
                </x-card>
            </div>
        </div>

    </form>
@endsection
