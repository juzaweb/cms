<div class="card card-menu-items" id="menu-box-{{ $key }}">
    <div class="card-header card-header-flex">
        <div class="d-flex flex-column justify-content-center">
            <h5 class="mb-0 text-capitalize">{{ $label }}</h5>
        </div>

        <div class="ml-auto d-flex align-items-stretch">
            <a href="javascript:void(0)" class="card-menu-show"><i class="fa fa-sort-down"></i></a>
        </div>
    </div>

    <div class="card-body @if($hidden ?? true) box-hidden @endif">
        <form action="{{ route('admin.menu.add-item') }}" method="post" class="form-menu-block">
            {!! $slot ?? '' !!}

            <input type="hidden" name="key" value="{{ $key }}">
            <input type="hidden" name="reload_after_save" value="0">

            <button type="submit" class="btn btn-primary btn-sm mt-2 px-3"><i class="fa fa-plus"></i> {{ trans('cms::app.add_to_menu') }}</button>
        </form>
    </div>
</div>