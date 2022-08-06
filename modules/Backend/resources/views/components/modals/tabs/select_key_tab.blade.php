<p class="mt-2">Use Activation Code activate {{ $moduleName }}</p>

<form method="post" action="{{ route('admin.module.activation-code', [$module]) }}" id="form-select-key">
    @csrf

    <input type="hidden" name="module" value="{{ $name }}">

    @if($codes)

        {{ Field::select(trans('cms::app.premium.activation_code'), 'key', [
            'required' => true,
            'options' => $codes
        ]) }}

        <button type="submit" class="btn btn-primary mt-2">
            Use Activation Code
        </button>
    @else
        <p>No license to use</p>
    @endif
</form>
