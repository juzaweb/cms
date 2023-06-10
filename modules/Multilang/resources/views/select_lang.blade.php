{{ Field::select($model, 'locale', [
    'options' => $languages,
    'value' => $selected,
]) }}
