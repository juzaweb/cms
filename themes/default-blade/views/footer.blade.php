<section class="wrapper__section p-0">
    <div class="wrapper__section__components">
        <footer>
            <div class="wrapper__footer bg__footer-dark pb-0">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            {{ dynamic_sidebar('footer_column_1') }}
                        </div>

                        <div class="col-md-3">
                            {{ dynamic_sidebar('footer_column_2') }}
                        </div>

                        <div class="col-md-3">
                            {{ dynamic_sidebar('footer_column_3') }}
                        </div>

                        <div class="col-md-3">
                            {{ dynamic_sidebar('footer_column_4') }}
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <figure class="image-logo">
                                    <img src="{{ get_logo() }}" alt="" class="logo-footer">
                                </figure>
                            </div>

                            <div class="col-md-8 my-auto ">
                                <div class="social__media">
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <a href="#" class="btn btn-social rounded text-white facebook">
                                                <i class="fa fa-facebook"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="#" class="btn btn-social rounded text-white twitter">
                                                <i class="fa fa-twitter"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="#" class="btn btn-social rounded text-white whatsapp">
                                                <i class="fa fa-whatsapp"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="#" class="btn btn-social rounded text-white telegram">
                                                <i class="fa fa-telegram"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="#" class="btn btn-social rounded text-white linkedin">
                                                <i class="fa fa-linkedin"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer bottom -->
            <div class="wrapper__footer-bottom bg__footer-dark">
                <div class="container ">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="border-top-1 bg__footer-bottom-section">

                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <span>
                                            Copyright © 2021
                                            <a href="#">{{ config('title') }}</a>
                                        </span>
                                    </li>
                                </ul>

                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </footer>
    </div>
</section>

<a href="javascript:" id="return-to-top">
    <i class="fa fa-chevron-up"></i>
</a>

