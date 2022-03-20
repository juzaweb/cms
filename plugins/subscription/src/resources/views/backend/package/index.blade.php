@extends('cms::layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="btn-group float-right">
                <a href="{{ $linkCreate }}" class="btn btn-success">
                    <i class="fa fa-plus-circle"></i> {{ trans('cms::app.add_new') }}
                </a>
            </div>
        </div>
    </div>

    {{ $dataTable->render() }}

    <div class="box-hidden">
        <form action="" method="post" target="_blank" class="form-test-payment">
            @csrf

            <input type="hidden" name="object_id">
        </form>
    </div>

    <script type="text/javascript">
        $('.table').on('click', '.sync-package', function () {
            let url = $(this).data('url');
            let btn = $(this);
            let icon = btn.find('i').attr('class');

            btn.find('i').attr('class', 'fa fa-spinner fa-spin');
            btn.prop("disabled", true);

            ajaxRequest(url, {}, {
                callback: function (response) {
                    btn.find('i').attr('class', icon);
                    btn.prop("disabled", false);

                    show_message(response);
                },
                failCallback: function (response) {
                    btn.find('i').attr('class', icon);
                    btn.prop("disabled", false);

                    show_message(response);
                }
            });
        });

        $('.table').on('click', '.show-modal-payment', function () {
            let module = $(this).data('module');
            let pack = $(this).data('package');
            let url = "{{ route('subscription.package.modal-test') }}";

            let btn = $(this);
            let icon = btn.find('i').attr('class');

            btn.find('i').attr('class', 'fa fa-spinner fa-spin');
            btn.prop("disabled", true);

            ajaxRequest(url, {
                module: module,
                package: pack
            }, {
                method: 'GET',
                callback: function (response) {
                    btn.find('i').attr('class', icon);
                    btn.prop("disabled", false);

                    $('#show-modal').empty();
                    $('#show-modal').html(response.data.html);
                    initSelect2('#show-modal #modal-payment');
                    $('#show-modal #modal-payment').modal();
                },
                failCallback: function (response) {
                    btn.find('i').attr('class', icon);
                    btn.prop("disabled", false);
                }
            });
        });

        $('#modal-payment').on('click', '.test-payment', function () {
            let driver = $('#modal-payment select[name=method]').val();
            let object = $('#modal-payment select[name=object]').val();
            let pack = $(this).data('package');

            let actionUrl = "{{ route(
                'subscription.redirect',
                ['__DRIVER__', '__PACKAGE__']
                ) }}";

            actionUrl = actionUrl.replace('__DRIVER__', driver);
            actionUrl = actionUrl.replace('__PACKAGE__', pack);

            $('.form-test-payment').attr('action', actionUrl);
            $('.form-test-payment input[name=object_id]').val(object);
            $('.form-test-payment').submit();
        });
    </script>

@endsection
