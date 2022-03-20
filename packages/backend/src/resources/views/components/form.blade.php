<form
        action="{{ $action ?? '' }}"
        method="post"
        class="form-ajax"
        id="{{ random_string() }}"
>
    @csrf

    @if(isset($method) && $method == 'put')
        @method('PUT')
    @endif

    {{ $slot ?? '' }}

</form>