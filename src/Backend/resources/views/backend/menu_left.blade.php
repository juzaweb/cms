<ul class="mymo__menuLeft__navigation">
    @php
        $items = \Mymo\Core\Helpers\MenuCollection::make(apply_filters('mymo.admin_menu', []));
    @endphp

    @foreach($items as $item)
        @if($item->hasChildren())
            <li class="mymo__menuLeft__item mymo__menuLeft__submenu mymo__menuLeft__item-{{ $item->get('url') }}">
            <span class="mymo__menuLeft__item__link">
                <i class="mymo__menuLeft__item__icon {{ $item->get('icon') }}"></i>

                <span class="mymo__menuLeft__item__title">{{ $item->get('title') }}</span>
            </span>

                <ul class="mymo__menuLeft__navigation">
                    @foreach($item->getChildrens() as $child)
                        <li class="mymo__menuLeft__item mymo__menuLeft__item-{{ $child->get('url') }}">
                            <a class="mymo__menuLeft__item__link" href="{{ url('admin-cp/' . $child->get('url')) }}" @if($child->get('turbolinks') === false) data-turbolinks="false" @endif>
                                <span class="mymo__menuLeft__item__title">{{ trans($child->get('title')) }}</span>

                                @if($icon = $child->get('icon'))
                                <i class="mymo__menuLeft__item__icon {{ $icon }}"></i>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @else
            <li class="mymo__menuLeft__item mymo__menuLeft__item-{{ $item->get('url') }}">
                <a class="mymo__menuLeft__item__link" href="{{ url('admin-cp/' . $item->get('url')) }}" @if($item->get('turbolinks') === false) data-turbolinks="false" @endif>
                    <i class="mymo__menuLeft__item__icon {{ $item->get('icon') }}"></i>
                    <span class="mymo__menuLeft__item__title">{{ $item->get('title') }}</span>

                </a>
            </li>
        @endif
    @endforeach
</ul>