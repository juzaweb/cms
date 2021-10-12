<div class="widget">
    <div class="banner-spot clearfix">
        <div class="banner-img">
            <a href="{{ $data['link'] ?? '' }}">
                <img src="{{ upload_url($data['banner'] ?? '') }}" alt="" class="img-fluid">
            </a>
        </div>
    </div>
</div>