<!-- ========== FOOTER ========== -->
<footer class="">
    <div class="bg-gray-6820">
        <div class="container px-md-5">
            <div class="row align-items-center space-top-1 pb-4">
                <div class="col-lg-2 text-center text-lg-left">
                    <a href="{{ home_url() }}" class="mb-4 mb-lg-0">
                        <img src="{{ upload_url(theme_setting('footer_logo') ?? logo_url()) }}" alt="{{ setting('sitename') }}" class="mb-2" style="height: 40px;">
                    </a>
                </div>

                <div class="col-lg-6 col-xl-7 text-center my-4 my-lg-0">
                    @php
                        $menu = nav_location('footer');
                    @endphp
                    <div class="nav justify-content-xl-center align-items-center font-size-1 flex-nowrap flex-xl-wrap overflow-auto">
                        @foreach($menu?->items ?? [] as $item)
                            <div class="nav-item flex-shrink-0">
                                <a class="nav-link text-gray-6600 pr-4" href="{{ $item->getUrl() }}"
                                   @if($item->target == '_blank') target="_blank" @endif>{{ $item->label }}</a>
                            </div>
                            @if(!$loop->last)
                                <span class="text-gray-6600">|</span>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-4 col-xl-3 d-flex justify-content-center justify-content-lg-start">
                    <ul class="list-unstyled mx-n2 mb-0 d-flex flex-wrap align-items-center ml-lg-auto">
                        @php
                            $socials = config('itube.socials', []);
                        @endphp

                        @foreach($socials as $social)
                            @php
                            $url = theme_setting('social_' . $social);
                            if (!$url) {
                                continue;
                            }
                            @endphp

                            <li class="px-1">
                                <a href="{{ $url }}"
                                   class="btn bg-gray-6700 rounded-circle justify-content-center p-0 avatar avatar-sm d-flex flex-wrap align-items-center" target="_blank">
                                    <i class="font-size-17 fab fa-{{ $social }} text-white"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="d-flex pb-5">
                <p class="font-size-13 text-gray-6800 mx-auto mb-0">Copyright © 2020, {{ setting('sitename') }}. All Rights Reserved</p>
            </div>
        </div>
    </div>
</footer>
<!-- ========== END FOOTER ========== -->
