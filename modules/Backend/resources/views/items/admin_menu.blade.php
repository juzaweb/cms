@foreach($items as $item)
    @if($item->hasChildren())
        <li class="juzaweb__menuLeft__item juzaweb__menuLeft__submenu juzaweb__menuLeft__item-{{ $item->get('url') }}">
            <span class="juzaweb__menuLeft__item__link">
                <i class="juzaweb__menuLeft__item__icon {{ $item->get('icon') }}"></i>

                <span class="juzaweb__menuLeft__item__title">{{ $item->get('title') }}</span>
            </span>

            <ul class="juzaweb__menuLeft__navigation">
            @foreach($item->getChildrens() as $child)
                <li class="juzaweb__menuLeft__item juzaweb__menuLeft__item-{{ $child->get('url') }}">
                    <a class="juzaweb__menuLeft__item__link" href="{{ admin_url($child->get('url')) }}">
                        <span class="juzaweb__menuLeft__item__title">{{ trans($child->get('title')) }}</span>
                        {{--<i class="juzaweb__menuLeft__item__icon fe fe-film"></i>--}}
                    </a>
                </li>
            @endforeach
            </ul>
        </li>
    @else
        <li class="juzaweb__menuLeft__item juzaweb__menuLeft__item-{{ $item->get('url') }}">
            <a class="juzaweb__menuLeft__item__link" href="{{ admin_url($item->get('url')) }}">
                <i class="juzaweb__menuLeft__item__icon {{ $item->get('icon') }}"></i>
                <span class="juzaweb__menuLeft__item__title">{{ $item->get('title') }}</span>

            </a>
        </li>
    @endif
@endforeach
