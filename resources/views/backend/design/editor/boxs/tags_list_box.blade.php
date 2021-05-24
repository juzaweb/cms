@php
    $title = @$option_card[$input['name']]['title'];

    $tags = null;
    if (isset($option_card[$input['name']]['tags']) && is_array($option_card[$input['name']]['tags'])) {
        $tags = \App\Core\Models\Category\Tags::where('shop_id', '=', $shop_id)
            ->where('status', '=', 1)
            ->whereIn('id', $option_card[$input['name']]['tags']);
    }

    $order = 'name_ASC';
    if (isset($option_card[$input['name']]['order'])) {
        $order = $option_card[$input['name']]['order'];
    }
@endphp
<div class="theme-setting theme-setting--text editor-item">
    <label class="next-label">{{ trans('main.title') }}</label>
    <input type="text" name="{{ $card['code'] }}[{{ $input['name'] }}][title]" class="next-input" value="{{ $title }}" autocomplete="off">
</div>

<div class="theme-setting theme-setting--text editor-item">
    <label class="next-label">{{ trans('main.tags') }}</label>
    <select name="{{ $card['code'] }}[{{ $input['name'] }}][tags][]" class="next-input load-product-tags" multiple>
        @if($tags)
            @foreach($tags as $tag)
                <option value="{{ $tag->id }}" selected>{{ $tag->name }}</option>
            @endforeach
        @endif
    </select>
</div>

<div class="theme-setting theme-setting--text editor-item">
    <label class="next-label">{{ trans('main.order') }}</label>
    <select name="{{ $card['code'] }}[{{ $input['name'] }}][order]">
        <option value="name_ASC" @if($order == 'name_ASC') selected @endif>{{ trans('main.name') }} {{ trans('main.from_a_z') }}</option>
        <option value="name_DESC" @if($order == 'name_DESC') selected @endif>{{ trans('main.name') }} {{ trans('main.from_z_a') }}</option>
    </select>
</div>