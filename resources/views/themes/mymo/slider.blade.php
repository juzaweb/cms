@if(@$home->slider->status == 1)
<div class="container">
    <div class="text-center"></div>
    <div class="row fullwith-slider">
        @php
            $sliders = slider_setting(@$home->slider->slider);
        @endphp
        <!-- Wrapper For Slides -->
        <div id="halim-fullwith-slider-widget-2" class="owl-carousel owl-carousel-fullwidth owl-theme">
            @if($sliders)
                @foreach($sliders as $index => $item)
                <div class="post-{{ $i }} item">
                    <a href="{{ @$item->link }}" title="{{ @$item->title }}">
                        <img src="{{ image_url(@$item->image) }}" alt="{{ @$item->title }}"  class="slide-image" />
                        <div class="slide-text">
                            <h3 class="slider-title">{{ @$item->title }}</h3>
                            <div class="slider-meta hidden-xs">
                                <p>{{ @$item->description }}</p>										            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            @endif
        </div><!-- End of Wrapper For Slides -->
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                var owl = $('#halim-fullwith-slider-widget-2');
                owl.owlCarousel({
                    rtl:false,
                    items: 1,
                    loop: true,
                    animateOut: 'fadeOutLeft',
                    animateIn: 'fadeInRight',
                    smartSpeed: 450,
                    autoplay: true,
                    autoplayTimeout: 4000,
                    autoHeight: true,
                    autoplayHoverPause: true,
                    nav: true,
                    navText: ['<i class="hl-down-open rotate-left"></i>', '<i class="hl-down-open rotate-right"></i>'],
                    responsiveClass: true,
                });
            });
        </script>

    </div>
</div>
@endif
