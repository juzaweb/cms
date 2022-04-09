<li class="juzaweb__menuLeft__item juzaweb__menuLeft__item-{{ $item->get('slug') }}">
    <a class="juzaweb__menuLeft__item__link @if($active) juzaweb__menuLeft__item--active @endif" href="{{ $adminUrl . $item->getUrl() }}" @if($item->get('turbolinks') === false) data-turbolinks="false" @endif>

        <span class="juzaweb__menuLeft__item__title">{{ $item->get('title') }}</span>

        <i class="juzaweb__menuLeft__item__icon {{ $item->get('icon') }}"></i>
    </a>
</li>