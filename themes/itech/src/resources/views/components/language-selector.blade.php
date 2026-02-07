@php
    $languages = languages();
    $currentLocale = app()->getLocale();
    $multipleLanguageConfig = setting('multiple_language', 'none');
@endphp

@if($multipleLanguageConfig !== 'none' && $languages->count() > 1)
<div class='language-selector'>
    <div class='widget LinkList' data-version='2'>
        <div class='widget-content'>
            <ul>
                <li class='language-dropdown'>
                    <a href='javascript:void(0)' class='language-toggle' title='{{ __('itech::translation.select_language') }}'>
                        <i class='fas fa-globe'></i>
                        <span>{{ strtoupper($currentLocale) }}</span>
                        <i class='fas fa-angle-down'></i>
                    </a>
                    <ul class='language-menu'>
                        @foreach($languages as $code => $language)
                            <li class='{{ $code === $currentLocale ? 'active' : '' }}'>
                                <a href='{{ $language->getChangeUrl($languages) }}'>
                                    {{ $language->name }} ({{ strtoupper($code) }})
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
@endif
