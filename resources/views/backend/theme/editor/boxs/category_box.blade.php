@php
    $title = @$option_card[$input['name']]['title'];
    $ctype = @$option_card[$input['name']]['ctype'];
    $category_id = @$option_card[$input['name']]['category'];
    $type_id = @$option_card[$input['name']]['type'];

    $category = genre_info($category_id);
    $type = type_info($type_id);

    $order = 'id_DESC';
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
        <label class="next-label">{{ trans('app.title') }}</label>
        <input type="text" name="{{ $card['code'] }}[{{ $input['name'] }}][title]" class="next-input" value="{{ $title }}" autocomplete="off">
    </div>

    <div class="theme-setting theme-setting--text editor-item">
        <label class="next-label">{{ trans('app.type') }}</label>
        <select name="{{ $card['code'] }}[{{ $input['name'] }}][ctype]" class="next-input select-ctype">
            <option value="1" @if($ctype == 1) selected @endif>{{ trans('app.category') }}</option>
        </select>
    </div>

    <div class="form-box-category @if($ctype && $ctype != 1) box-hidden @endif" >
        <div class="theme-setting theme-setting--text editor-item">
            <label class="next-label">{{ trans('app.category') }}</label>
            <select name="{{ $card['code'] }}[{{ $input['name'] }}][category]" class="load-product-category" @if($ctype && $ctype != 1) disabled @endif>
                @if($category)
                    <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                @endif
            </select>
        </div>
    </div>

    <div class="theme-setting theme-setting--text editor-item">
        <label class="next-label">{{ trans('app.sort') }}</label>
        <select name="{{ $card['code'] }}[{{ $input['name'] }}][order]">
            <option value="id_DESC" @if($order == 'id_DESC') selected @endif>{{ trans('app.latest') }}</option>
            <option value="id_ASC" @if($order == 'id_ASC') selected @endif>{{ trans('app.oldest') }}</option>
            <option value="price_DESC" @if($order == 'price_DESC') selected @endif>{{ trans('app.price_high_to_low') }}</option>
            <option value="price_ASC" @if($order == 'price_ASC') selected @endif>{{ trans('app.price_low_to_high') }}</option>
        </select>
    </div>

    @if(isset($input['limit']))
        <div class="theme-setting theme-setting--text editor-item">
            <label class="next-label">{{ trans('app.limit') }}</label>
            <input type="number" name="{{ $card['code'] }}[{{ $input['name'] }}][limit]" class="next-label" value="{{ $limit }}">
        </div>
    @endif

</div>