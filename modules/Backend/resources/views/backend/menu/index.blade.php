@extends('cms::layouts.backend')

@section('content')
    <div id="menu-container">
        <div class="row alert alert-light p-3 no-radius">

            <div class="col-md-6 form-select-menu">
                <div class="alert-default">
                    @if($menu)
                    {{ trans('cms::app.select_menu_to_edit') }}:
                    <select name="id" class="w-25 form-control load-menu">
                        <option value="{{ $menu->id }}" selected>{{ $menu->name }}</option>
                    </select>

                    {{ trans('cms::app.or') }}
                    @endif

                    <a href="javascript:void(0)" class="ml-1 btn-add-menu"><i class="fa fa-plus"></i> {{ trans('cms::app.create_new_menu') }}</a>
                </div>
            </div>

            <div class="col-md-6 form-add-menu box-hidden">
                <form action="{{ route('admin.menu.store') }}" method="post" class="form-ajax form-inline">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" autocomplete="off" required placeholder="{{ trans('cms::app.menu_name') }}">
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> {{ trans('cms::app.add_menu') }}</button>
                </form>
            </div>
        </div>

        @if(!empty($menu))
            <div class="row mt-5">
                <div class="col-md-4">
                    <h5 class="mb-2 font-weight-bold">{{ trans('cms::app.add_menu_items') }}</h5>

                    @do_action('juzaweb.add_menu_items')
                </div>

                <div class="col-md-8">
                    <h5 class="mb-2 font-weight-bold">{{ trans('cms::app.menu_structure') }}</h5>

                    <form action="{{ route('admin.menu.update', [$menu->id]) }}" method="post" class="form-ajax form-menu-structure">
                        <input type="hidden" name="id" value="{{ $menu->id }}">
                        <input type="hidden" name="reload_after_save" value="0">

                        @method('PUT')

                        <div class="card">
                            <div class="card-header bg-light pb-1">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-3">{{ trans('cms::app.menu_name') }}</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="name" id="name" class="form-control" value="{{ $menu->name ?? '' }}" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="btn-group float-right">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ trans('cms::app.save') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body" id="form-menu">
                                <div class="dd" id="jw-menu-builder">
                                    <ol class="dd-list">
                                        {!! jw_nav_backend_menu([
                                                'menu' => $menu,
                                                'item_view' => view('cms::backend.items.menu_item'),
                                        ]) !!}
                                    </ol>
                                </div>

                                <hr>

                                @foreach($navMenus as $key => $navMenu)
                                    <div class="form-check mb-2">
                                        <label class="form-check-label">
                                            <input class="form-check-input" name="location[]" type="checkbox" value="{{ $key }}" @if(isset($location[$key]) && $location[$key] == $menu->id) checked @endif>
                                            {{ $navMenu->get('location') }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="card-footer">
                                <div class="btn-group">
                                    <a href="javascript:void(0)" class="text-danger delete-menu" data-id="{{ $menu->id }}">{{ trans('cms::app.delete_menu') }}</a>
                                </div>

                                <div class="btn-group float-right">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ trans('cms::app.save') }}</button>
                                </div>
                            </div>

                            <textarea name="content" id="items-output" class="form-control box-hidden"></textarea>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
@endsection
