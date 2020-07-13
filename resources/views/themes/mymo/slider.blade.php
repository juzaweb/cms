<div class="container">
    <div class="text-center"></div>    <div class="row fullwith-slider">
        <!-- Wrapper For Slides -->
        <div id="halim-fullwith-slider-widget-2" class="owl-carousel owl-carousel-fullwidth owl-theme">
            @for ($i = 0; $i < 4; $i++)
                <div class="post-{{ $i }} item">
                    <a href="/hoa-bi-ngan-beautiful-reborn-flower" title="Hoa Bỉ Ngạn">
                        <img src="{{ asset('uploads/2020/05/binganhoa.gif') }}" alt="Hoa Bỉ Ngạn"  class="slide-image" />
                        <div class="slide-text">
                            <h3 class="slider-title">Hoa Bỉ Ngạn</h3>
                            <div class="slider-meta hidden-xs">
                                <p>[Beautiful Reborn Flower (2020)]</p>										</div>
                        </div>
                    </a>
                </div>
            @endfor
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
