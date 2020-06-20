<ul class="cui__menuLeft__navigation" data-turbolinks-track="reload">
    <li class="cui__menuLeft__item">
        <a class="cui__menuLeft__item__link" href="{{ route('admin.dashboard') }}">
            <span class="cui__menuLeft__item__title">@lang('app.dashboard')</span>
            <i class="cui__menuLeft__item__icon fe fe-home"></i>
        </a>
    </li>

    <li class="cui__menuLeft__item cui__menuLeft__submenu">
      <span class="cui__menuLeft__item__link">
        <span class="cui__menuLeft__item__title">@lang('app.movies')</span>
        <i class="cui__menuLeft__item__icon fe fe-pie-chart"></i>
      </span>
        <ul class="cui__menuLeft__navigation">
            <li class="cui__menuLeft__item">
                <a class="cui__menuLeft__item__link" href="{{ route('admin.genres') }}">
                    <span class="cui__menuLeft__item__title">@lang('app.genres')</span>
                </a>
            </li>
            <li class="cui__menuLeft__item">
                <a class="cui__menuLeft__item__link" href="">
                    <span class="cui__menuLeft__item__title">Chart.js</span>
                </a>
            </li>
            <li class="cui__menuLeft__item">
                <a class="cui__menuLeft__item__link" href="">
                    <span class="cui__menuLeft__item__title">Chartist.js</span>
                </a>
            </li>
            <li class="cui__menuLeft__item">
                <a class="cui__menuLeft__item__link" href="">
                    <span class="cui__menuLeft__item__title">Peity</span>
                </a>
            </li>
        </ul>
    </li>

    <li class="cui__menuLeft__item">
        <a class="cui__menuLeft__item__link" href="">
            <span class="cui__menuLeft__item__title">@lang('app.movies')</span>
            <i class="cui__menuLeft__item__icon fe fe-feather"></i>
        </a>
    </li>
</ul>