<p class="mt-2">Connect to your JuzaWeb Account and activate {{ $moduleName }}</p>

<form method="post" action="{{ route('admin.module.login-juzaweb') }}" id="form-login-juzaweb">
    <input type="hidden" name="module" value="{{ $name }}">

    @csrf

    {{ Field::text(trans('cms::app.email'), 'email', [
        'required' => true,
        'data' => [
            'rule-email' => true
        ]
    ]) }}

    {{ Field::text(trans('cms::app.password'), 'password', [
        'required' => true,
        'type' => 'password'
    ]) }}

    <button type="submit" class="btn btn-primary">
        Connect to Account
    </button>
</form>
