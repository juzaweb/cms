@extends('layouts.backend')

@section('title', trans('main.menu'))

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
                <form action="{{ route('vendor.admin.menu.add_menu') }}" method="post" class="form-ajax" data-success="add_menu_success">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('main.add_menu') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="menu-name" class="form-label">{{ trans('main.menu_name') }}</label>
                            <input type="text" name="name" id="menu-name" class="form-control" autocomplete="off" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ trans('main.save') }}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle"></i> {{ trans('main.close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection