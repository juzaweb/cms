<div class='widget Label' data-version='2' id='Label1'>
    <div class='widget-title'>
        <h3 class='title'>
            {{ $sidebar->label }}
        </h3>
    </div>
    @php
        $tags = \Juzaweb\Modules\Core\Models\Tag::limit(20)->get();
    @endphp
    <div class='widget-content cloud-label'>
        <ul>
            @foreach($tags as $tag)
                <li>
                    <a class='label-name' href="{{ $tag->getUrl() }}">
                        {{ $tag->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>