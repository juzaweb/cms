@extends('cms::layouts.backend')

@section('content')
    <div class="row mb-2">
        <div class="col-md-6"></div>

        <div class="col-md-6 text-right">
            <a href="javascript:void(0)" class="btn btn-success" data-toggle="modal" data-target="#add-language-modal"><i class="fa fa-plus"></i> {{ trans('cms::app.add_language') }}</a>
        </div>
    </div>

    {{ $dataTable->render() }}

    <div class="modal fade" id="add-language-modal" role="dialog">
        <div class="modal-dialog" role="document">
            <form action="" method="post" class="form-ajax" data-success="add_language_success">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ trans('cms::app.add_language') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('cms::app.close') }}">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        {{ Field::select(trans('cms::app.language'), 'code', [
                            'class' => 'load-locales',
                            'data' => [
                                'placeholder' => trans('cms::app.choose_language')
                            ],
                        ]) }}
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ trans('cms::app.add_language') }}</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('cms::app.close') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript">
        var toggleLink = "{{ route('admin.language.toggle-default', ['__ID__']) }}";

        function add_language_success(form, data) {
            $('#add-language-modal').modal('hide');
            table.refresh();
        }

        $('table').on('change', 'input[name=default]', function () {
            let id = $(this).val();

            ajaxRequest(toggleLink.replace('__ID__', id), {}, {
                method: 'PUT',
                callback: function (response) {
                    show_message(response);
                }
            });
        });
    </script>

@endsection
