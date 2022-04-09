<form method="post" action="{{ route('admin.setting.save') }}" class="form-ajax">
    <input type="hidden" name="form" value="demo-site">

    @php
    $options = ['' => trans('cms::app.user')];
    if ($user = get_config('demo_user')) {
        $user = \Juzaweb\CMS\Models\User::find($user);
        $options = [$user->id => $user->name];
    }
    @endphp

    {{ Field::select(__('User Demo'), 'demo_user', [
        'class' => 'load-users',
        'options' => $options,
    ]) }}

    <button type="submit" class="btn btn-success">
        <i class="fa fa-save"></i> {{ trans('cms::app.save') }}
    </button>
</form>