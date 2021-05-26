@php
    $title = @$option_card[$input['name']]['title'];
    $ctype = @$option_card[$input['name']]['ctype'] ?: 1;
    $body = @$option_card[$input['name']]['body'];
    $menu_id = null;
    if (isset($option_card[$input['name']]['menu'])) {
        $menu_id = intval($option_card[$input['name']]['menu']);
    }
    $menu = menu_info($menu_id);
@endphp
<div class="form-product-list">
    <div class="theme-setting theme-setting--text editor-item">
        <label class="next-label">{{ trans('mymo_core::app.title') }}</label>
        <input type="text" name="{{ $card['code'] }}[{{ $input['name'] }}][title]" class="next-input" value="{{ $title }}" autocomplete="off">
    </div>

    <div class="theme-setting theme-setting--text editor-item ctype-select">
        <label class="next-label">{{ trans('mymo_core::app.type') }}</label>
        <select name="{{ $card['code'] }}[{{ $input['name'] }}][ctype]" class="next-input select-ctype">
            <option value="1" @if($ctype == 1) selected @endif>@lang('mymo_core::app.menu_link')</option>
            <option value="2" @if($ctype == 2) selected @endif>@lang('mymo_core::app.custom_html')</option>
        </select>
    </div>

    <div class="theme-setting theme-setting--text editor-item ctype ctype-1 @if($ctype != 1) box-hidden @endif">
        <label class="next-label">{{ trans('mymo_core::app.menu') }}</label>
        <select name="{{ $card['code'] }}[{{ $input['name'] }}][menu]" class="next-input load-menu" data-placeholder="--- @lang('mymo_core::app.choose_menu') ---">
            @if($menu)
                <option value="{{ $menu->id }}">{{ $menu->name }}</option>
            @endif
        </select>
    </div>

    <div class="theme-setting theme-setting--text editor-item ctype ctype-2 @if($ctype != 2) box-hidden @endif">
        <label class="next-label">{{ trans('mymo_core::app.content') }} (html)</label>
        <textarea class="form-control" name="{{ $card['code'] }}[{{ $input['name'] }}][body]" rows="5">{!! $body !!}</textarea>
    </div>
</div>