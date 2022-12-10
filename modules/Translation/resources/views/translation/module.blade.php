@extends('cms::layouts.backend')

@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="btn-group float-right">
                <a href="javascript:void(0)" class="btn btn-success" data-toggle="modal" data-target="#modal-add">{{ trans('cms::app.add_language') }}</a>
            </div>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-12">
            <div class="table-responsive mb-5">
                <table class="table juzaweb-table">
                    <thead>
                        <tr>
                            <th data-field="index" data-width="3%" data-formatter="index_formatter" data-align="center">#</th>
                            <th data-width="10%" data-field="code">{{ trans('cms::app.language_code') }}</th>
                            <th data-field="name">{{ trans('cms::app.language') }}</th>
                            <th data-width="20%" data-formatter="actions_formatter">{{ trans('cms::app.actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-add" role="dialog" aria-labelledby="modal-add-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post"
                  action="{{ route('admin.translations.type.add', [$type]) }}"
                  class="form-ajax"
                  data-success="add_language_success"
                  data-notify="true"
            >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-add-title">{{ trans('cms::app.add_language') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('cms::app.close') }}">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ trans('cms::app.language') }}</label>
                            <select name="locale" id="locale" class="load-locales" data-placeholder="--- {{ trans('cms::app.language') }} ---"></select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ trans('cms::app.add') }}</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('cms::app.close') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript">
        let linkLocale = "{{ route('admin.translations.locale', [$type, '__LOCALE__']) }}";

        function add_language_success(form, response) {
            setTimeout(function () {
                window.location = "";
            }, 300);
        }

        function index_formatter(value, row, index) {
            return (index + 1);
        }

        function actions_formatter(value, row, index) {
            return `<a href="${linkLocale.replace('__LOCALE__', row.code)}" class="btn btn-info btn-sm"><i class="fa fa-language"></i> ${juzaweb.lang.translate}</a>`;
        }

        let table = new JuzawebTable({
            url: '{{ route('admin.translations.type.get-data', [$type]) }}',
        });
    </script>
@endsection
