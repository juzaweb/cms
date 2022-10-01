<div class="form-group">
    @php
        $value = $value ?? [];
        $value = !is_array($value) ? [$value] : $value;

        $options = [];
        if ($value) {
            $options = \Juzaweb\Backend\Models\Post::whereIn('id', $value)
                ->get(['id', 'title'])
                ->mapWithKeys(function ($item) {
                    return [
                        $item->id => $item->title
                    ];
                })
                ->toArray();
        }
    @endphp
    <label class="col-form-label" for="{{ $id ?? $name }}">{{ $label ?? $name }}</label>
    <select
        name="{{ ($multiple ?? false) ? "{$name}[]" : $name }}"
        id="{{ $id ?? $name }}"
        class="form-control load-posts"
        data-type="{{ $type ?? '' }}"
        {{ ($multiple ?? false) ? 'multiple' : '' }}
    >
        @foreach($options as $key => $tname)
            <option value="{{ $key }}" @if(in_array($key, $value)) selected @endif>{{ $tname }}</option>
        @endforeach
    </select>
</div>
