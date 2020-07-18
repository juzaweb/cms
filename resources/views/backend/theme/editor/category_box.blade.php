@php
    $title = @$option_card[$input['name']]['title'];
    $ctype = @$option_card[$input['name']]['ctype'];
    $category_id = @$option_card[$input['name']]['category'];
    $type_id = @$option_card[$input['name']]['type'];
    $vendor_id = @$option_card[$input['name']]['vendor'];

    $category = $category_info($category_id, $shop_id);
    $type = $type_info($type_id, $shop_id);
    $vendor = $vendor_info($vendor_id, $shop_id);
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
        <label class="next-label">{{ trans('main.title') }}</label>
        <input type="text" name="{{ $card['code'] }}[{{ $input['name'] }}][title]" class="next-input" value="{{ $title }}" autocomplete="off">
    </div>

    <div class="theme-setting theme-setting--text editor-item">
        <label class="next-label">{{ trans('main.type') }}</label>
        <select name="{{ $card['code'] }}[{{ $input['name'] }}][ctype]" class="next-input select-ctype">
            <option value="1" @if($ctype == 1) selected @endif>{{ trans('main.category') }}</option>
            <option value="3" @if($ctype == 3) selected @endif>{{ trans('main.vendor') }}</option>
        </select>
    </div>

    <div class="form-box-category" @if($ctype && $ctype != 1) style="display: none;" @endif>
        <div class="theme-setting theme-setting--text editor-item">
            <label class="next-label">{{ trans('main.category') }}</label>
            <select name="{{ $card['code'] }}[{{ $input['name'] }}][category]" class="load-product-category" @if($ctype && $ctype != 1) disabled @endif>
                @if($category->id)
                    <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                @endif
            </select>
        </div>
    </div>

    <div class="form-box-vendor" @if($ctype != 3) style="display: none;" @endif>
        <div class="theme-setting theme-setting--text editor-item">
            <label class="next-label">{{ trans('main.vendor') }}</label>
            <select name="{{ $card['code'] }}[{{ $input['name'] }}][vendor]" class="load-vendor" @if($ctype != 3) disabled @endif>
                @if($vendor->id)
                    <option value="{{ $vendor->id }}" selected>{{ $vendor->name }}</option>
                @endif
            </select>
        </div>
    </div>

    <div class="theme-setting theme-setting--text editor-item">
        <label class="next-label">{{ trans('main.sort') }}</label>
        <select name="{{ $card['code'] }}[{{ $input['name'] }}][order]">
            <option value="id_DESC" @if($order == 'id_DESC') selected @endif>{{ trans('main.latest') }}</option>
            <option value="id_ASC" @if($order == 'id_ASC') selected @endif>{{ trans('main.oldest') }}</option>
            <option value="price_DESC" @if($order == 'price_DESC') selected @endif>{{ trans('main.price_high_to_low') }}</option>
            <option value="price_ASC" @if($order == 'price_ASC') selected @endif>{{ trans('main.price_low_to_high') }}</option>
        </select>
    </div>

    @if(isset($input['limit']))
        <div class="theme-setting theme-setting--text editor-item">
            <label class="next-label">{{ trans('main.limit') }}</label>
            <input type="number" name="{{ $card['code'] }}[{{ $input['name'] }}][limit]" class="next-label" value="{{ $limit }}">
        </div>
    @endif

</div>