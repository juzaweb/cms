<div class="navbar-container">
    <div class="container">
        <nav class="navbar halim-navbar main-navigation" role="navigation" data-dropdown-hover="1">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed pull-left" data-toggle="collapse" data-target="#halim" aria-expanded="false">
                    <span class="sr-only">Menu</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <button type="button" class="navbar-toggle collapsed pull-right" data-toggle="collapse" data-target="#user-info" aria-expanded="false">
                    <span class="hl-dot-3 rotate" aria-hidden="true"></span>
                </button>
                <button type="button" class="navbar-toggle collapsed pull-right expand-search-form" data-toggle="collapse" data-target="#search-form" aria-expanded="false">
                    <span class="hl-search" aria-hidden="true"></span>
                </button>
                <button type="button" class="navbar-toggle collapsed pull-right get-bookmark-on-mobile">
                    <i class="hl-bookmark" aria-hidden="true"></i>
                    <span class="count">0</span>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="halim">
                <div class="menu-main-menu-container">
                    <ul id="menu-main-menu" class="nav navbar-nav navbar-left">

                        <li class="current-menu-item active">
                            <a title="Trang chủ" href="/">Trang chủ</a>
                        </li>

                        <li><a title="Phim bộ" href="{{ route('tv_series') }}">Phim bộ</a></li>

                        <li class="mega dropdown"><a title="Thể loại" href="#" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true">Thể loại <span class="caret"></span></a>
                            <ul role="menu" class=" dropdown-menu">
                                <li><a title="Phim Âm Nhạc" href="/am-nhac">Phim Âm Nhạc</a></li>

                            </ul>
                        </li>

                    </ul>
                </div>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
        <div class="collapse navbar-collapse" id="search-form">
            <div id="mobile-search-form" class="halim-search-form"></div>
        </div>
        <div class="collapse navbar-collapse" id="user-info">
            <div id="mobile-user-login"></div>
        </div>
    </div>
</div>
