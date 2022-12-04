@if(isset($item['children']))
<li class="treeview-animated-items">
    <a href="javascript:void(0)" class="closed">
        <i class="fa fa-angle-right"></i>
        <span>
            @if($item['type'] == 'dir')
                <i class="fa fa-folder ic-w mx-1"></i>
            @else
                <i class="fa fa-file-o ic-w mx-1"></i>
            @endif
            {{ $item['name'] }}
        </span>
    </a>
    <ul class="nested">
        @foreach($item['children'] as $directory)
            @component('cms::backend.appearance.editor.components.tree_item', [
                'item' => $directory,
                'theme' => $theme
            ])
            @endcomponent
        @endforeach
    </ul>
</li>
@else
<li>
    <a
        href="{{ route('admin.theme.editor', [$theme]) .'?file='. $item['path'] }}"
        class="treeview-animated-element is-file"
        data-path="{{ $item['path'] }}"
    >
        @if($item['type'] == 'dir')
            <i class="fa fa-folder ic-w mx-1"></i>
        @else
            <i class="fa fa-file-o ic-w mx-1"></i>
        @endif

        {{ $item['name'] }}
    </a>
</li>
@endif
