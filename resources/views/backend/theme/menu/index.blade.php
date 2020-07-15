@extends('layouts.backend')

@section('title', trans('app.menu'))

@section('content')

    {{ Breadcrumbs::render('manager', [
            'name' => trans('app.menu'),
            'url' => route('admin.theme.menu')
        ]) }}

    <div class="cui__utils__content">
        <div class="row mt-5">
            <div class="col-md-5">
                @include('backend.theme.menu.form_left')
            </div>

            <div class="col-md-7">
                @include('backend.theme.menu.form_right')
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-add-menu">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.theme.menu.add') }}" method="post" class="form-ajax" data-success="add_menu_success">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('app.add_menu') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="menu-name" class="form-label">{{ trans('app.menu_name') }}</label>
                            <input type="text" name="name" id="menu-name" class="form-control" autocomplete="off" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ trans('app.save') }}</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times-circle"></i> {{ trans('app.close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function add_menu_success(form) {
            $('#menu-name').val('');
            $('#modal-add-menu').modal('hide');
        }
    </script>

    <template id="menu-item">
        <li class='dd-item' id="item-{id}" data-id="{id}" data-content="{content}" data-object_id="{object_id}" data-url="{url}" data-new_tab="{new_tab}" data-object_type="{object_type}">
            <div class='dd-handle'>{content}</div>
            <div class='float-right item-edit'>
                <a href='javascript:void(0)' class="edit-menu-item" title='{{ trans('main.edit') }}'><i class='fa fa-edit'></i></a>
                <a href='javascript:void(0)' class='text-red remove-menu-item' title='{{ trans('main.remove') }}'><i class='fa fa-times-circle'></i></a>
            </div>
            {children}
        </li>
    </template>

    <script type="text/javascript">
        var dataJson = '{!! isset($menu->content) ? $menu->content : '{}' !!}';
    </script>
    <script type="text/javascript" src="{{ asset('styles/js/add-menu.js') }}"></script>
@endsection