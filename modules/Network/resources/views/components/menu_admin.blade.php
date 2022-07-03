<div class="mr-3">
    <div class="dropdown d-none d-sm-block">
        <a href="javascript:void(0)" class="dropdown-toggle text-nowrap" data-toggle="dropdown">
            <i class="fa fa-server"></i>
            <span class="dropdown-toggle-text"> {{ trans('cms::app.network.network') }}</span>
        </a>

        <div class="dropdown-menu" role="menu">
            <a
                class="dropdown-item"
                href="{{ route('admin.network.dashboard') }}"
                data-turbolinks="false"
            >
                {{ trans('cms::app.dashboard') }}
            </a>

            <a
                class="dropdown-item"
                href="{{ route('admin.network.sites.index') }}"
                data-turbolinks="false"
            >{{ trans('cms::app.network.sites') }}</a>

            <a
                class="dropdown-item"
                href="{{ route('admin.network.themes.index') }}"
                data-turbolinks="false"
            >{{ trans('cms::app.themes') }}</a>

            <a
                class="dropdown-item"
                href="{{ route('admin.network.plugins.index') }}"
                data-turbolinks="false"
            >{{ trans('cms::app.plugins') }}</a>
        </div>
    </div>
</div>
