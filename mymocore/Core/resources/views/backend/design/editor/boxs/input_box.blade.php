@php
$input_value = '';
if (isset($option_card[$input['name']])) {
    if (is_array($option_card[$input['name']][$iinput])) {
        $input_value = (isset($option_card[$input['name']][$iinput]) ? $option_card[$input['name']][$iinput]: '');
    }
    else {
        $input_value = (isset($option_card[$input['name']]) ? $option_card[$input['name']] : '');
    }
}

$input_name = $card['code'] . '['. $input['name'] .']';
if (strpos($input['name'], '[')) {
    $explode = explode('[', $input['name']);
    $input_name = $card['code'] . '['. $explode[0] .']' . '[' . $explode[1];

    if (!isset(${'index_'. $card['code'] .'_' . $explode[0]})) {
        ${'index_'. $card['code'] .'_' . $explode[0]} = 0;
    }
    else {
        ${'index_'. $card['code'] .'_' . $explode[0]} += 1;
    }

    $input_value = isset($option_card[$explode[0]][${'index_'. $card['code'] .'_' . $explode[0]}]) ? $option_card[$explode[0]][${'index_'. $card['code'] .'_' . $explode[0]}] : '';
}
@endphp

<div class="theme-setting theme-setting--text editor-item">
    @switch($input['element'])
    @case('input')
    <label class="next-label" for="input-{{ $index }}-{{ $icard }}-{{ $iinput }}">{{ $input['title'] }}</label>
    <input type="text" name="{{ $input_name }}" class="next-input" id="input-{{ $index }}-{{ $icard }}-{{ $iinput }}" value="{{ $input_value }}" autocomplete="off">
    @break
    
    @case('textarea')
    <label class="next-label" for="input-{{ $index }}-{{ $icard }}-{{ $iinput }}">{{ $input['title'] }}</label>
    <textarea name="{{ $input_name }}" class="next-input" id="input-{{ $index }}-{{ $icard }}-{{ $iinput }}" rows="4">{{ $input_value }}</textarea>
    @break
    
    @case('media')
    <label class="next-label" for="input-{{ $index }}-{{ $icard }}-{{ $iinput }}">{{ $input['title'] }}</label>
    <div class="review" id="review-{{ $index }}-{{ $icard }}-{{ $iinput }}">
        <img src="{{ image_url($input_value) }}" alt="">
    </div>
    
    <p><a href="javascript:void(0)" class="load-media" data-input="input-{{ $index }}-{{ $icard }}-{{ $iinput }}" data-preview="review-{{ $index }}-{{ $icard }}-{{ $iinput }}"><i class="fa fa-edit"></i> {{ trans('mymo_core::app.change') }}</a></p>
    <input type="hidden" name="{{ $input_name }}" id="input-{{ $index }}-{{ $icard }}-{{ $iinput }}" value="{{ $input_value }}">
    @break

    @case('slider')
        <label class="next-label" for="input-{{ $index }}-{{ $icard }}-{{ $iinput }}">{{ $input['title'] }}</label>
        <select name="{{ $input_name }}" class="load-slider">
            @if($input_value)
                @php
                    $slider = \App\Core\Models\Sliders::where('id', '=', $input_value)
                        ->first();
                @endphp
                <option value="{{ $input_value }}">{{ @$slider->name }}</option>
            @endif
        </select>
    @break

    @case('select_genre')
    <label class="next-label" for="input-{{ $index }}-{{ $icard }}-{{ $iinput }}">{{ $input['title'] }}</label>
    <select name="{{ $input_name }}" class="load-genres">
        @if($input_value)
            @php
                $genre = \App\Core\Models\Category\Genres::where('id', '=', $input_value)
                    ->first(['name']);
            @endphp
            <option value="{{ $input_value }}">{{ @$genre->name }}</option>
        @endif
    </select>
    @break

    @case('select_genres')
    <label class="next-label" for="input-{{ $index }}-{{ $icard }}-{{ $iinput }}">{{ $input['title'] }}</label>
    <select name="{{ $input_name }}[]" class="load-genres" multiple>
        @if($input_value)
            @php
                $genres = \App\Core\Models\Category\Genres::whereIn('id', $input_value)
                    ->get(['id', 'name']);
            @endphp

            @foreach($genres as $item)
            <option value="{{ @$item->id }}" selected>{{ @$item->name }}</option>
            @endforeach
        @endif
    </select>
    @break

    @case('icon')
        <label class="next-label" for="input-{{ $index }}-{{ $icard }}-{{ $iinput }}">{{ @$input['title'] }}</label>
        <input type="text" name="{{ $input_name }}" class="next-input select-icon" value="{{ @$input_value }}">
    @break

    @endswitch
</div>