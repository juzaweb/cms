<div id="wrapper">

    <header class="tech-header header">
        <div class="container-fluid">
            <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <a class="navbar-brand" href="/"><img src="{{ get_logo() }}" alt="{{ get_config('title') }}"></a>

                <div class="collapse navbar-collapse" id="navbarCollapse">
                    {!! jw_nav_menu([
                            'container_before' => '<ul class="navbar-nav mr-auto">',
                            'container_after' => '</ul>',
                            'theme_location' => 'primary',
                    ]) !!}

                    <ul class="navbar-nav mr-2">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fa fa-rss"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fa fa-android"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fa fa-apple"></i></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>