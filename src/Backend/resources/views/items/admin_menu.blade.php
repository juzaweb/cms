@foreach($items as $item)
    @if($item->hasChildren())
        <li class="cui__menuLeft__item cui__menuLeft__submenu cui__menuLeft__item-{{ $item->get('url') }}">
            <span class="cui__menuLeft__item__link">
                <i class="cui__menuLeft__item__icon {{ $item->get('icon') }}"></i>

                <span class="cui__menuLeft__item__title">{{ $item->get('title') }}</span>
            </span>

            <ul class="cui__menuLeft__navigation">
            @foreach($item->getChildrens() as $child)
                <li class="cui__menuLeft__item cui__menuLeft__item-{{ $child->get('url') }}">
                    <a class="cui__menuLeft__item__link" href="{{ url('admin-cp/' . $child->get('url')) }}">
                        <span class="cui__menuLeft__item__title">{{ trans($child->get('title')) }}</span>
                        {{--<i class="cui__menuLeft__item__icon fe fe-film"></i>--}}
                    </a>
                </li>
            @endforeach
            </ul>
        </li>
    @else
        <li class="cui__menuLeft__item cui__menuLeft__item-{{ $item->get('url') }}">
            <a class="cui__menuLeft__item__link" href="{{ url('admin-cp/' . $item->get('url')) }}">
                <i class="cui__menuLeft__item__icon {{ $item->get('icon') }}"></i>
                <span class="cui__menuLeft__item__title">{{ $item->get('title') }}</span>

            </a>
        </li>
    @endif
@endforeach