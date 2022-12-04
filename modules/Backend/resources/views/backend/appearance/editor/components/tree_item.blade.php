@if(isset($item['children']))
<li class="treeview-animated-items">
    <a class="closed">
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
            ])
            @endcomponent
        @endforeach
    </ul>
</li>
@else
<li>
    <div class="treeview-animated-element">

        @if($item['type'] == 'dir')
            <i class="fa fa-folder ic-w mx-1"></i>
        @else
            <i class="fa fa-file-o ic-w mx-1"></i>
        @endif

        {{ $item['name'] }}
    </div>
</li>
@endif
