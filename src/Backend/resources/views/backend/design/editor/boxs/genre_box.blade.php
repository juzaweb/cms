@php
    $title = @$option_card[$input['name']]['title'];
    $ctype = @$option_card[$input['name']]['ctype'] ?: 1;
    $format = @$option_card[$input['name']]['format'];
    $genre_id = @$option_card[$input['name']]['genre'];
    $type_id = @$option_card[$input['name']]['type'];
    $country_id = @$option_card[$input['name']]['country'];

    $genre = genre_info($genre_id);
    $type = type_info($type_id);
    $country = type_info($country_id);

    $order = 'updated_at_DESC';
    if (isset($option_card[$input['name']]['order'])) {
        $order = $option_card[$input['name']]['order'];
    }

    $limit = (int) @$input['limit']['default'];
    if ($limit <= 0) {
        $limit = 6;
    }

    if (isset($option_card[$input['name']]['limit'])) {
        $limit = intval($option_card[$input['name']]['limit']);
    }
@endphp

<div class="form-product-list">
    <div class="theme-setting theme-setting--text editor-item">
        <label class="next-label">{{ trans('mymo::app.title') }}</label>
        <input type="text" name="{{ $card['code'] }}[{{ $input['name'] }}][title]" class="next-input" value="{{ $title }}" autocomplete="off">
    </div>

    <div class="theme-setting theme-setting--text editor-item">
        <label class="next-label">{{ trans('mymo::app.type') }}</label>
        <select name="{{ $card['code'] }}[{{ $input['name'] }}][ctype]" class="next-input select-ctype">
            <option value="1" @if($ctype == 1) selected @endif>{{ trans('mymo::app.genre') }}</option>
            <option value="2" @if($ctype == 2) selected @endif>{{ trans('mymo::app.type') }}</option>
            <option value="3" @if($ctype == 3) selected @endif>{{ trans('mymo::app.country') }}</option>
        </select>
    </div>

    <div class="theme-setting theme-setting--text editor-item ctype ctype-1 @if($ctype != 1) box-hidden @endif">
        <label class="next-label">{{ trans('mymo::app.genre') }}</label>
        <select name="{{ $card['code'] }}[{{ $input['name'] }}][genre]" class="load-genres" @if($ctype != 1) disabled @endif>
            @if($genre)
                <option value="{{ $genre->id }}" selected>{{ $genre->name }}</option>
            @endif
        </select>
    </div>

    <div class="theme-setting theme-setting--text editor-item ctype ctype-2 @if($ctype != 2) box-hidden @endif">
        <label class="next-label">{{ trans('mymo::app.type') }}</label>
        <select name="{{ $card['code'] }}[{{ $input['name'] }}][type]" class="load-types" @if($ctype != 2) disabled @endif>
            @if($type)
                <option value="{{ $type->id }}" selected>{{ $type->name }}</option>
            @endif
        </select>
    </div>

    <div class="theme-setting theme-setting--text editor-item ctype ctype-3 @if($ctype != 3) box-hidden @endif">
        <label class="next-label">{{ trans('mymo::app.country') }}</label>
        <select name="{{ $card['code'] }}[{{ $input['name'] }}][type]" class="load-types" @if($ctype != 3) disabled @endif>
            @if($country)
                <option value="{{ $country->id }}" selected>{{ $country->name }}</option>
            @endif
        </select>
    </div>

    <div class="theme-setting theme-setting--text editor-item">
        <label class="next-label">{{ trans('mymo::app.format') }}</label>
        <select name="{{ $card['code'] }}[{{ $input['name'] }}][format]" class="next-input">
            <option value="">--- {{ trans('mymo::app.format') }} ---</option>
            <option value="1" @if($format == 1) selected @endif>{{ trans('mymo::app.movies') }}</option>
            <option value="2" @if($format == 2) selected @endif>{{ trans('mymo::app.tv_series') }}</option>
        </select>
    </div>

    <div class="theme-setting theme-setting--text editor-item">
        <label class="next-label">{{ trans('mymo::app.sort') }}</label>
        <select name="{{ $card['code'] }}[{{ $input['name'] }}][order]">
            <option value="updated_at_DESC" @if($order == 'updated_at_DESC') selected @endif>{{ trans('mymo::app.latest') }}</option>
            <option value="updated_at_ASC" @if($order == 'updated_at_ASC') selected @endif>{{ trans('mymo::app.oldest') }}</option>
            <option value="view_DESC" @if($order == 'view_DESC') selected @endif>{{ trans('mymo::app.views_high_to_low') }}</option>
            <option value="view_ASC" @if($order == 'view_ASC') selected @endif>{{ trans('mymo::app.views_low_to_high') }}</option>
        </select>
    </div>

    <div class="theme-setting theme-setting--text editor-item">
        <label class="next-label">{{ trans('mymo::app.limit') }}</label>
        <input type="number" name="{{ $card['code'] }}[{{ $input['name'] }}][limit]" class="next-label" value="{{ $limit }}">
    </div>

</div>