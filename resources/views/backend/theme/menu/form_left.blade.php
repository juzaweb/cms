<div class="card">
    <div class="card-header">
        <div class="w-75">
            <select name="id" class="form-control load-menu" data-placeholder="-- {{ trans('main.choose_menu') }} --">
                @if(isset($menu->id))
                    <option value="{{ $menu->id }}" selected>{{ $menu->name }}</option>
                @endif
            </select>
        </div>
        <a href="javascript:void(0)" class="ml-1 add-new-menu"><i class="fa fa-plus"></i> {{ trans('main.add_new') }}</a>
    </div>

    <div class="card-body">
        <ul class="accordionjs m-0" id="accordion" data-active-index="false">


            <li class="acc_section">
                <div class="acc_head"><h3><i class="fa fa-plus-circle"></i> {{ trans('main.product_category') }}</h3></div>
                <div class="acc_content">
                    <form action="" method="post" class="add-menu-item">

                        <input type="hidden" name="type" value="product_category">

                        <div class="form-group">
                            <select name="object_id" class="form-control load-product-category" data-placeholder="-- {{ trans('main.product_category') }} --"></select>
                        </div>

                        <div class="form-group">
                            <input type="text" name="title" class="form-control" placeholder="{{ trans('main.title') }}" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label class="custom-switch">
                                <input type="checkbox" name="open_new_tab" class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description"> {{ trans('main.open_new_tab') }}</span>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-success btn-sm mt-1"><i class="fa fa-plus"></i> {{ trans('main.add') }}</button>
                    </form>
                </div>
            </li>


        </ul>
    </div>
</div>