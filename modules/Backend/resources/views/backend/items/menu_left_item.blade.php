<li class="juzaweb__menuLeft__item juzaweb__menuLeft__item-{{ $item->get('slug') }} @if($active) juzaweb__menuLeft__submenu--toggled @endif">
    <a class="juzaweb__menuLeft__item__link @if($active) juzaweb__menuLeft__item--active @endif" href="{{ $adminUrl . $item->getUrl() }}" @if($item->get('turbolinks') === false) data-turbolinks="false" @endif>

        @if($icon ?? true)
            <i class="juzaweb__menuLeft__item__icon {{ $item->get('icon') }}"></i>
        @endif

        <span class="juzaweb__menuLeft__item__title">{{ $item->get('title') }}</span>
    </a>
</li>
