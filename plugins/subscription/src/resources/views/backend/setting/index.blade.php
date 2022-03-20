@extends('cms::layouts.backend')

@section('content')
    <form method="post" action="" class="form-ajax">
        <div class="row">
            <div class="col-md-6"></div>

            <div class="col-md-6">
                <div class="btn-group float-right">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> {{ trans('cms::app.save') }}
                    </button>

                    <button type="reset" class="btn btn-default">
                        <i class="fa fa-refresh"></i> {{ trans('cms::app.reset') }}
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Paypal</h5>
                    </div>

                    <div class="card-body">
                        {{
                            Field::checkbox(
                                trans('cms::app.enabled'),
                                'subscription[paypal][enable]',
                                [
                                    'checked' => $data['paypal']['enable'] ?? false
                                ]
                            )
                        }}

                        {{
                            Field::select(
                                trans('subr::content.mode'),
                                'subscription[paypal][mode]',
                                [
                                    'options' => [
                                        'sandbox' => trans('subr::content.sandbox'),
                                        'live' => trans('subr::content.live'),
                                    ]
                                ]
                            )
                        }}

                        {{ Field::text(
                            trans('subr::content.sandbox_client_id'),
                            'subscription[paypal][sandbox_client_id]',
                            [
                                'value' => $data['paypal']['sandbox_client_id'] ?? ''
                            ]
                        ) }}

                        {{ Field::text(
                            trans('subr::content.sandbox_secret'),
                            'subscription[paypal][sandbox_secret]',
                            [
                                'value' => $data['paypal']['sandbox_secret'] ?? ''
                            ]
                        ) }}

                        {{ Field::text(
                            trans('subr::content.sandbox_webhook_id'),
                            'subscription[paypal][sandbox_webhook_id]',
                            [
                                'value' => $data['paypal']['sandbox_webhook_id'] ?? ''
                            ]
                        ) }}

                        {{ Field::text(
                            trans('subr::content.live_client_id'),
                            'subscription[paypal][live_client_id]',
                            [
                                'value' => $data['paypal']['live_client_id'] ?? ''
                            ]
                        ) }}

                        {{ Field::text(
                            trans('subr::content.live_secret'),
                            'subscription[paypal][live_secret]',
                            [
                                'value' => $data['paypal']['live_secret'] ?? ''
                            ]
                        ) }}

                        {{ Field::text(
                            trans('subr::content.live_webhook_id'),
                            'subscription[paypal][live_webhook_id]',
                            [
                                'value' => $data['paypal']['live_webhook_id'] ?? ''
                            ]
                        ) }}
                    </div>
                </div>
            </div>

            <div class="col-md-6">

            </div>
        </div>
    </form>
@endsection
