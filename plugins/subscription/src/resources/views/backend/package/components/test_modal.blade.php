<div class="modal fade" id="modal-payment" tabindex="-1" role="dialog" aria-labelledby="modal-payment-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-payment-label">
                    {{ trans('subr::content.test_payment') }}
                </h5>

                <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{ Field::select(trans('subr::content.method'), 'method', [
                    'options' => [
                        'paypal' => 'Paypal'
                    ]
                ]) }}

                {{ Field::select(trans('subr::content.object'), 'object', [
                    'class' => 'load-subscription-objects',
                    'data' => [
                        'module' => $module,
                        'placeholder' => trans('subr::content.object'),
                    ]
                ]) }}
            </div>

            <div class="modal-footer">
                <button
                        type="button"
                        class="btn btn-primary test-payment"
                        data-package="{{ $package }}"
                >
                    {{ trans('subr::content.test_payment') }}
                </button>

                <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">
                    {{ trans('cms::app.close') }}
                </button>
            </div>
        </div>
    </div>
</div>