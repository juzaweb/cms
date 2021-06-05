<div class="card card-menu-items">
    <div class="card-header card-header-flex">
        <div class="d-flex flex-column justify-content-center">
            <h5 class="mb-0">{{ $menuBlock->get('label') }}</h5>
        </div>

        <div class="ml-auto d-flex align-items-stretch">
            <a href="javascript:void(0)" class="card-menu-show"><i class="fa fa-sort-down"></i></a>
        </div>
    </div>

    <div class="card-body @if($hidden ?? true) box-hidden @endif">
        <form action="{{ route('admin.menu.add-item') }}" method="post" class="form-menu-block">
            {{ ($menuBlock->get('component'))::formAdd() }}

            <input type="hidden" name="key" value="{{ $key }}">
            <input type="hidden" name="reload_after_save" value="0">
            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add to menu</button>
        </form>
    </div>
</div>