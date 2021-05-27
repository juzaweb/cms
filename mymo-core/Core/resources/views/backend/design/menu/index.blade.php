@extends('layouts.backend')

@section('title', trans('mymo_core::app.menu'))

@section('content')

    {{ Breadcrumbs::render('manager', [
            'name' => trans('mymo_core::app.menu'),
            'url' => route('admin.design.menu')
        ]) }}

    <div class="cui__utils__content">
        <div class="row mt-5">
            <div class="col-md-5">
                @include('mymo_core::backend.design.menu.form_left')
            </div>

            <div class="col-md-7">
                @include('mymo_core::backend.design.menu.form_right')
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-add-menu">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.design.menu.add') }}" method="post" class="form-ajax">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('mymo_core::app.add_menu') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="menu-name" class="form-label">{{ trans('mymo_core::app.menu_name') }}</label>
                            <input type="text" name="name" id="menu-name" class="form-control" autocomplete="off" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ trans('mymo_core::app.save') }}</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times-circle"></i> {{ trans('mymo_core::app.close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-edit-menu">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ trans('mymo_core::app.add_menu') }}</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <input type='hidden' id='id' class='form-control' value="">
                <div class="modal-body">
                    <div class='form-group'>
                        <label class="form-label">{{ trans('mymo_core::app.title') }}</label>
                        <input type='text' id='content' class='form-control' value="">
                    </div>

                    <div class='form-group'>
                        <label class="form-label">{{ trans('mymo_core::app.url') }}</label>
                        <input type='text' id='url' class='form-control' value="">
                    </div>

                    <div class="form-group">
                        <label class="custom-switch">
                            <input type="checkbox" id="new_tab" class="custom-switch-input" value="1">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description"> {{ trans('mymo_core::app.open_new_tab') }}</span>
                        </label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary save-menu-item"><i class="fa fa-save"></i> {{ trans('mymo_core::app.save') }}</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle"></i> {{ trans('mymo_core::app.close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <template id="menu-item">
        <li class='dd-item' id="item-{id}" data-id="{id}" data-content="{content}" data-object_id="{object_id}" data-url="{url}" data-new_tab="{new_tab}" data-object_type="{object_type}">
            <div class='dd-handle'>{content}</div>
            <div class='float-right item-edit'>
                <a href='javascript:void(0)' class="edit-menu-item" title='{{ trans('mymo_core::app.edit') }}'><i class='fa fa-edit'></i></a>
                <a href='javascript:void(0)' class='text-red remove-menu-item' title='{{ trans('mymo_core::app.remove') }}'><i class='fa fa-times-circle'></i></a>
            </div>
            {children}
        </li>
    </template>

    <script type="text/javascript">
        var dataJson = '{!! isset($menu->content) ? $menu->content : '{}' !!}';
    </script>
    <script type="text/javascript" src="{{ asset('styles/js/add-menu.js') }}"></script>
@endsection