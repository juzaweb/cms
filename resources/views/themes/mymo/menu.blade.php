<div class="navbar-container">
    <div class="container">
        <nav class="navbar mymo-navbar main-navigation" role="navigation" data-dropdown-hover="1">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed pull-left" data-toggle="collapse" data-target="#mymo" aria-expanded="false">
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
            @php
                $menu_main = menu_setting(@$header->main_menu->menu->menu);
            @endphp
            <div class="collapse navbar-collapse" id="mymo">
                <div class="menu-main-menu-container">
                    @if($menu_main)
                    <ul id="menu-main-menu" class="nav navbar-nav navbar-left">
                        @foreach($menu_main as $menu)
                            @php
                                $childrens = isset($menu->children) ? $menu->children : [];
                            @endphp

                            @if(empty($childrens))
                                <li @if(request()->is(@$menu->url)) class="current-menu-item active" @endif>
                                    <a title="{{ @$menu->content }}" href="{{ @$menu->url }}" @if(@$menu->new_tab == 1) target="_blank" data-turbolinks="false" @endif>{{ @$menu->content }}</a>
                                </li>
                            @else
                                <li class="mega dropdown"><a title="{{ @$menu->content }}" href="#" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true">{{ @$menu->content }} <span class="caret"></span></a>
                                    <ul role="menu" class=" dropdown-menu">
                                        @foreach($childrens as $children)
                                        <li><a href="{{ @$children->url }}" title="{{ @$children->content }}" @if(@$children->new_tab == 1) target="_blank" data-turbolinks="false" @endif>{{ @$children->content }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
        <div class="collapse navbar-collapse" id="search-form">
            <div id="mobile-search-form" class="mymo-search-form"></div>
        </div>
        <div class="collapse navbar-collapse" id="user-info">
            <div id="mobile-user-login"></div>
        </div>
    </div>
</div>
