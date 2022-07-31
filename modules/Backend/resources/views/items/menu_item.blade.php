<li class="nav-item @if(!empty($children)) dropdown has-submenu menu-large hidden-md-down hidden-sm-down hidden-xs-down @endif">
    <a
        class="nav-link @if(!empty($children)) dropdown-toggle @endif"
        href="{{ $item->link }}"
        @if(!empty($children))
            id="dropdown-{{ $item->id }}"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
        @endif
    >{{ $item->label }}</a>

    @if(!empty($children))
        <ul class="dropdown-menu megamenu" aria-labelledby="dropdown-{{ $item->id }}">
            @foreach($children as $child)
                {!! $builder->buildItem($child) !!}
            @endforeach
        </ul>
    @endif
</li>
