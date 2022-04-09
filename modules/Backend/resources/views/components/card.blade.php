<div class="card {{ $class ?? '' }}">
    @if($label ?? false)
        <div class="card-header">
            <div class="d-flex flex-column justify-content-center">
                <h5 class="mb-0">{{ $label }}</h5>
            </div>
        </div>
    @endif
    <div class="card-body">
        {{ $slot }}
    </div>
</div>