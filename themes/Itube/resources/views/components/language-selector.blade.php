@php
    $languages = languages();
    $currentLocale = app()->getLocale();
    $multipleLanguageConfig = setting('multiple_language', 'none');
@endphp

@if($multipleLanguageConfig !== 'none' && $languages->count() > 1)
    <li class="col pr-xl-0 px-2 px-sm-3">
        <!-- Language Dropdown -->
        <div class="hs-unfold">
            <a class="js-hs-unfold-invoker dropdown-nav-link dropdown-toggle py-4 position-relative d-flex align-items-center" 
               href="javascript:;"
               data-hs-unfold-options='{
                    "target": "#languageDropdown",
                    "type": "css-animation",
                    "event": "click"
                }'>
                <span class="d-flex align-items-center text-dark">
                    <i class="fas fa-globe mr-1"></i>
                    <span class="text-uppercase">{{ $currentLocale }}</span>
                </span>
            </a>

            <div id="languageDropdown" class="hs-unfold-content dropdown-menu my-account-dropdown" style="min-width: 150px;">
                @foreach($languages as $code => $language)
                    <a class="dropdown-item d-flex align-items-center {{ $code === $currentLocale ? 'active font-weight-bold' : '' }}" href="{{ $language->getChangeUrl($languages) }}">
                        {{ $language->name }} ({{ strtoupper($code) }})
                    </a>
                @endforeach
            </div>
        </div>
        <!-- End Language Dropdown -->
    </li>
@endif
