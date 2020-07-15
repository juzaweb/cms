<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-8">
                <select name="id" class="form-control load-menu" data-placeholder="--- {{ trans('app.choose_menu') }} ---">
                    @if(isset($menu->id))
                        <option value="{{ $menu->id }}" selected>{{ $menu->name }}</option>
                    @endif
                </select>
            </div>

            <div class="col-md-4">
                <a href="javascript:void(0)" class="ml-1" data-toggle="modal" data-target="#modal-add-menu"><i class="fa fa-plus"></i> {{ trans('app.add_new') }}</a>
            </div>
        </div>

    </div>

    <div class="card-body">
        <ul class="accordionjs m-0" id="accordion" data-active-index="false">

            <li class="acc_section">
                <div class="acc_head"><h3><i class="fa fa-plus-circle"></i> {{ trans('app.genres') }}</h3></div>
                <div class="acc_content">
                    <form action="" method="post" class="add-menu-item">

                        <input type="hidden" name="type" value="genre">

                        <div class="form-group">
                            <div class="show-categories">
                                <ul class="mt-2 p-0">
                                    @foreach($genres as $genre)
                                    <li class="m-1" id="item-category-1">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="genres[]" class="custom-control-input" id="category-{{ $genre->id }}" value="{{ $genre->id }}">
                                            <label class="custom-control-label" for="category-{{ $genre->id }}">{{ $genre->name }}</label>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="custom-switch">
                                <input type="checkbox" name="open_new_tab" class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description"> {{ trans('app.open_new_tab') }}</span>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-success btn-sm mt-1"><i class="fa fa-plus"></i> {{ trans('app.add_to_menu') }}</button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</div>