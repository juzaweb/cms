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
                            <div class="ul-show-items">
                                <ul class="mt-2 p-0">
                                    @foreach($genres as $genre)
                                    <li class="m-1" id="item-genre-{{ $genre->id }}">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="items[]" class="custom-control-input" id="genre-{{ $genre->id }}" value="{{ $genre->id }}">
                                            <label class="custom-control-label" for="genre-{{ $genre->id }}">{{ $genre->name }}</label>
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
                                <span class="custom-switch-description"> {{ trans('app.open_new_tab') }}</span>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-success btn-sm mt-1"><i class="fa fa-plus"></i> {{ trans('app.add_to_menu') }}</button>
                    </form>
                </div>
            </li>

            <li class="acc_section">
                <div class="acc_head"><h3><i class="fa fa-plus-circle"></i> {{ trans('app.countries') }}</h3></div>
                <div class="acc_content">
                    <form action="" method="post" class="add-menu-item">

                        <input type="hidden" name="type" value="country">

                        <div class="form-group">
                            <div class="ul-show-items">
                                <ul class="mt-2 p-0">
                                    @foreach($countries as $country)
                                        <li class="m-1" id="item-country-{{ $country->id }}">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="items[]" class="custom-control-input" id="country-{{ $country->id }}" value="{{ $country->id }}">
                                                <label class="custom-control-label" for="country-{{ $country->id }}">{{ $country->name }}</label>
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
                                <span class="custom-switch-description"> {{ trans('app.open_new_tab') }}</span>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-success btn-sm mt-1"><i class="fa fa-plus"></i> {{ trans('app.add_to_menu') }}</button>
                    </form>
                </div>
            </li>

            <li class="acc_section">
                <div class="acc_head"><h3><i class="fa fa-plus-circle"></i> {{ trans('app.types') }}</h3></div>
                <div class="acc_content">
                    <form action="" method="post" class="add-menu-item">

                        <input type="hidden" name="type" value="type">

                        <div class="form-group">
                            <div class="ul-show-items">
                                <ul class="mt-2 p-0">
                                    @foreach($types as $type)
                                        <li class="m-1" id="item-type-{{ $type->id }}">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="items[]" class="custom-control-input" id="type-{{ $type->id }}" value="{{ $type->id }}">
                                                <label class="custom-control-label" for="type-{{ $type->id }}">{{ $type->name }}</label>
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
                                <span class="custom-switch-description"> {{ trans('app.open_new_tab') }}</span>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-success btn-sm mt-1"><i class="fa fa-plus"></i> {{ trans('app.add_to_menu') }}</button>
                    </form>
                </div>
            </li>

            <li class="acc_section">
                <div class="acc_head"><h3><i class="fa fa-plus-circle"></i> {{ trans('app.other_pages') }}</h3></div>
                <div class="acc_content">
                    <form action="" method="post" class="add-menu-item">

                        <input type="hidden" name="type" value="custom">

                        <div class="form-group">
                            <label class="col-form-label" for="add-title">@lang('app.title')</label>
                            <input type="text" name="title" id="add-title" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="add-url">@lang('app.pages')</label>
                            <select name="url" id="add-url" class="form-control">
                                <option value="">--- @lang('app.choose_page') ---</option>
                                <option value="/">@lang('app.home')</option>
                                <option value="/movies">@lang('app.movies')</option>
                                <option value="/tv-series">@lang('app.tv_series')</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="custom-switch">
                                <input type="checkbox" name="new_tab" class="custom-switch-input" value="1">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description"> {{ trans('app.open_new_tab') }}</span>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-success btn-sm mt-1"><i class="fa fa-plus"></i> {{ trans('app.add_to_menu') }}</button>
                    </form>
                </div>
            </li>

            <li class="acc_section">
                <div class="acc_head"><h3><i class="fa fa-plus-circle"></i> {{ trans('app.custom_url') }}</h3></div>
                <div class="acc_content">
                    <form action="" method="post" class="add-menu-item">

                        <input type="hidden" name="type" value="custom">

                        <div class="form-group">
                            <label class="col-form-label">@lang('app.title')</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label">@lang('app.url')</label>
                            <input type="text" name="url" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="custom-switch">
                                <input type="checkbox" name="new_tab" class="custom-switch-input" value="1">
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