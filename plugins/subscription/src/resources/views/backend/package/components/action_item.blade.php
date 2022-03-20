@php
    $disabled = ($row->is_free || $row->price <= 0);
@endphp
<div class="btn-group">
    <button
            type="button"
            class="btn btn-primary sync-package"
            data-url="{{ route('subscription.package.sync', [$row->id]) }}"
            @if($disabled) disabled @endif>
        <i class="fa fa-cog"></i> {{ trans('subr::content.sync') }}
    </button>

    <button type="button" class="btn btn-primary show-modal-payment" data-module="{{ $row->module }}" data-package="{{ $row->key }}">
        <i class="fa fa-send"></i> {{ trans('subr::content.test_payment') }}
    </button>
</div>