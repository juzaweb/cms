<div class="mymo-item">
    @php
        $genres = $item->getGenres();
        $countries = $item->getCountries();

        $genre_str = '';
        foreach ($genres as $genre) {
            $genre_str .= '<span class=category-name>'. $genre->name .'</span>';
        }

        $country_str = '';
        foreach ($countries as $country) {
            $country_str .= '<span class=category-name>'. $country->name .'</span>';
        }
    @endphp

    <a class="mymo-thumb" href="{{ route('watch', ['slug' => $item->slug]) }}" title="{{ $item->name }}{{ $item->other_name ? ' - ' . $item->other_name : '' }}">
        <figure>
            <img class="lazyload blur-up img-responsive" data-sizes="auto" data-src="{{ $item->getThumbnail() }}" alt="{{ $item->name }}{{ $item->other_name ? ' - ' . $item->other_name : '' }}" title="{{ $item->name }}{{ $item->other_name ? ' - ' . $item->other_name : '' }}">
        </figure>
        <span class="status">{{ $item->video_quality }}</span>
        <div class="icon_overlay"
             data-html="true"
             data-toggle="mymo-popover"
             data-placement="top"
             data-trigger="hover"
             title="<span class=film-title>{{ $item->name }}</span>"
             data-content="<div class=org-title>{{ $item->other_name }}</div>                            <div class=film-meta>
                                <div class=text-center>
                                    <span class=released><i class=hl-calendar></i> {{ $item->year }}</span>                                    <span class=runtime><i class=hl-clock></i> 87 Phút</span>                                </div>
                                <div class=film-content>{{ $item->short_description }}</div>
                                <p class=category>@lang('theme::app.countries'): {{ $country_str }}</p>
                                <p class=category>@lang('theme::app.genres'): {{ $genre_str }}</p>
                            </div>">
        </div>

        <div class="mymo-post-title-box">
            <div class="mymo-post-title ">
                <h2 class="entry-title">{{ $item->name }}</h2>
                <p class="original_title">{{ $item->other_name }}</p>
            </div>
        </div>
    </a>
</div>