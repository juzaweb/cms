<div class="position-relative h-100 max-w-240">
    <div class="py-6 pr-3d sidebar-area h-100">
        <!-- Categories -->
        @php
            $menu = nav_location('main');
        @endphp
        <div class="youtube-sidebar bg-white p-2">
            <ul class="list-unstyled m-0">
                <li>
                    <a href="{{ home_url() }}" class="sidebar-link">
                        <i class="fas fa-home"></i>
                        <span>{{ __('itube::translation.home') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ home_url('trending') }}" class="sidebar-link">
                        <i class="fas fa-star"></i>
                        <span>{{ __('itube::translation.trending') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ home_url('history') }}" class="sidebar-link">
                        <i class="fas fa-history"></i>
                        <span>{{ __('itube::translation.history') }}</span>
                    </a>
                </li>
            </ul>

            @if(($menu?->items ?? collect())->isNotEmpty())
                <ul class="list-unstyled m-0 border-top pt-3 mt-5">
                    @foreach($menu?->items ?? [] as $item)
                        <li>
                            <a href="{{ $item->getUrl() }}" class="sidebar-link"
                               @if($item->target == '_blank') target="_blank" @endif>
                                <span>{{ $item->label }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <!-- End Categories -->
    </div>
</div>
