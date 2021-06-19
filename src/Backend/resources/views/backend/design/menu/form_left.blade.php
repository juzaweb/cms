<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-8">
                <select name="id" class="form-control load-menu" data-placeholder="--- {{ trans('mymo_core::app.choose_menu') }} ---">
                    @if(isset($menu->id))
                        <option value="{{ $menu->id }}" selected>{{ $menu->name }}</option>
                    @endif
                </select>
            </div>

            <div class="col-md-4">
                <a href="javascript:void(0)" class="ml-1" data-toggle="modal" data-target="#modal-add-menu"><i class="fa fa-plus"></i> {{ trans('mymo_core::app.add_new') }}</a>
            </div>
        </div>

    </div>

    <div class="card-body">
        <ul class="accordionjs m-0" id="accordion" data-active-index="false">
            @foreach($postTypes as $postType)
            <li class="acc_section">
                <div class="acc_head"><h3><i class="fa fa-plus-circle"></i> {{ $postType->get('label') }}</h3></div>
                @php
                    $items = app($postType->get('model'))
                        ->limit(10)
                        ->get();
                @endphp
                <div class="acc_content">
                    <form action="" method="post" class="add-menu-item">

                        <input type="hidden" name="type" value="page">

                        <div class="form-group">
                            <div class="ul-show-items">
                                <ul class="mt-2 p-0">
                                    @foreach($items as $item)
                                        <li class="m-1" id="item-page-{{ $item->id }}">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="items[]" class="custom-control-input" id="page-{{ $item->id }}" value="{{ $item->id }}">
                                                <label class="custom-control-label" for="page-{{ $item->id }}">{{ $item->name ?? $item->title ?? '' }}</label>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="custom-switch">
                                <input type="checkbox" name="new_tab" class="custom-switch-input" value="1">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description"> {{ trans('mymo_core::app.open_new_tab') }}</span>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-success btn-sm mt-1"><i class="fa fa-plus"></i> {{ trans('mymo_core::app.add_to_menu') }}</button>
                    </form>
                </div>
            </li>
            @endforeach

            <li class="acc_section">
                <div class="acc_head"><h3><i class="fa fa-plus-circle"></i> {{ trans('mymo_core::app.custom_url') }}</h3></div>
                <div class="acc_content">
                    <form action="" method="post" class="add-menu-item">

                        <input type="hidden" name="type" value="custom">

                        <div class="form-group">
                            <label class="col-form-label">@lang('mymo_core::app.title')</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">@lang('mymo_core::app.url')</label>
                            <input type="text" name="url" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="custom-switch">
                                <input type="checkbox" name="new_tab" class="custom-switch-input" value="1">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description"> {{ trans('mymo_core::app.open_new_tab') }}</span>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-success btn-sm mt-1"><i class="fa fa-plus"></i> {{ trans('mymo_core::app.add_to_menu') }}</button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</div>