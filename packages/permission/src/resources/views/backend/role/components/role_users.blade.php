<div class="card">
    <div class="card-body">
        @php
            use Juzaweb\Permission\Models\Role;
            $options = Role::get()->mapWithKeys(function ($item) {
                return [$item->id => $item->name];
            })->toArray();
        @endphp

        {{ Field::select(trans('perm::content.roles'), 'roles[]', [
            'options' => $options,
            'value' => $model->roles->pluck('id')->toArray(),
            'multiple' => true
        ]) }}
    </div>
</div>