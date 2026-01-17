@extends('core::layouts.admin')

@section('content')
    <form action="" method="post" class="form-ajax">
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> {{ __('itube::translation.save_changes') }}
                </button>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-9">
                <x-card title="{{ __('itube::translation.page_settings') }}">
                    @php
                        $homePage = theme_setting('home_page')
                            ? \Juzaweb\Modules\Core\Models\Pages\Page::where('id', theme_setting('home_page'))->first()
                            : null;
                    @endphp

                    {{ Field::select(__('itube::translation.home_page'), 'home_page', ['value' => theme_setting('home_page')])->dropDownList([
                            $homePage?->id ?? '' => $homePage?->title ?? __('itube::translation.select_a_page'),
                        ])->dataUrl(load_data_url(\Juzaweb\Modules\Core\Models\Pages\Page::class, 'title')) }}

                    {{ Field::image(__('itube::translation.footer_logo'), 'footer_logo', ['value' => theme_setting('footer_logo')]) }}
                </x-card>

                <x-card title="{{ __('itube::translation.contact_information') }}">
                    {{ Field::text(__('itube::translation.contact_email'), 'contact_email', ['value' => theme_setting('contact_email')]) }}
                    {{ Field::text(__('itube::translation.contact_phone'), 'contact_phone', ['value' => theme_setting('contact_phone')]) }}
                    {{ Field::textarea(__('itube::translation.contact_address'), 'contact_address', ['value' => theme_setting('contact_address')]) }}
                </x-card>

                <x-card title="{{ __('itube::translation.socials') }}">
                    @foreach ($socials as $social)
                        {{ Field::text(ucfirst(explode('-', $social)[0]), "social_{$social}", ['value' => theme_setting("social_{$social}")]) }}
                    @endforeach
                </x-card>
            </div>
        </div>

    </form>
@endsection
