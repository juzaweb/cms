{{ Field::select($model, 'lang', [
    'options' => $languages,
    'value' => $selected
]) }}