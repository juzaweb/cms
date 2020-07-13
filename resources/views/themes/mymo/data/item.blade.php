<div class="halim-item">
        <a class="halim-thumb" href="{{ route('watch', ['slug' => $item->slug]) }}" title="{{ $item->name }}">
            <figure>
                <img class="lazyload blur-up img-responsive" data-sizes="auto" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="{{ $item->getThumbnail() }}" alt="{{ $item->name }}" title="{{ $item->name }}">
            </figure>
            <span class="status">HD</span>
            <span class="episode">Tập 3</span>
            <div class="icon_overlay" data-html="true"
                 data-toggle="halim-popover"
                 data-placement="top"
                 data-trigger="hover"
                 title="<span class=film-title>{{ $item->name }}</span>"
                 data-content="<div class=org-title>{{ $item->other_name }} (2020)</div>                            <div class=film-meta>
                                <div class=text-center>
                                    <span class=released><i class=hl-calendar></i> 2020</span>                                   </div>
                                <div class=film-content>{{ $item->short_description }}</div>
                                <p class=category>Quốc gia: <span class=category-name>Trung Quốc</span></p>                                <p class=category>Thể loại: <span class=category-name>Hài Hước</span><span class=category-name>Tình Cảm</span></p>
                            </div>">
            </div>

            <div class="halim-post-title-box">
                <div class="halim-post-title ">
                    <h2 class="entry-title">{{ $item->name }}</h2><p class="original_title">{{ $item->other_name }} {{ $item->release ? '(' . $item->release->format('Y') . ')' : '' }}</p>
                </div>
            </div>
        </a>
    </div>