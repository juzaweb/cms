<li
    class="dd-item"
    @foreach($data as $key => $item)
        data-{{ $key }}="{{ $item }}"
    @endforeach
>
    <div class="dd-handle">
        {{ $data['text'] }}
        <a href="javascript:void(0)" class="dd-nodrag show-menu-edit">
            <i class="fa fa-sort-down"></i>
        </a>
    </div>

    <div class="form-item-edit box-hidden">
        {{ ($menuBlock->get('component'))::formEdit(collect($data)) }}

        <a href="javasctipt:void(0)" class="text-danger">Delete</a>
        <a href="javasctipt:void(0)" class="text-info">Cancel</a>
    </div>
</li>