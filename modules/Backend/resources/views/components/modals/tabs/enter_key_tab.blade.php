<p class="mt-2"></p>
<form method="post" action="{{ route('admin.module.activation-code', [$module]) }}" id="form-activation-code">
    @csrf

    {{ Field::text(trans('cms::app.key'), 'key', [
        'required' => true,
        'placeholder' => 'Paste Activation code here'
    ]) }}

    <input type="hidden" name="module" value="{{ $name }}">

    <button type="submit" class="btn btn-primary">
        Activate
    </button>
</form>
