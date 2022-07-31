@extends('cms::layouts.backend')

@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="btn-group float-right">
                <a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal" data-target="#modal-add">{{ trans('cms::app.add_language') }}</a>
            </div>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-12">
            <div class="table-responsive mb-5">
                <table class="table juzaweb-table">
                    <thead>
                        <tr>
                            <th data-width="5%" data-field="code">{{ trans('cms::app.language_code') }}</th>
                            <th data-field="name">{{ trans('cms::app.language') }}</th>
                            <th data-width="20%" data-formatter="actions_formatter">{{ trans('cms::app.actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-add-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post" action="{{ route('admin.translations.type.add', [$type]) }}" class="form-ajax">
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
                            <select name="locale" class="load-locales" data-placeholder="--- {{ trans('cms::app.language') }} ---"></select>
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
        var linkLocale = "{{ route('admin.translations.locale', [$type, '__LOCALE__']) }}";

        function actions_formatter(value, row, index) {
            return `<a href="${linkLocale.replace('__LOCALE__', row.code)}">${juzaweb.lang.translations}</a>`;
        }

        var table = new JuzawebTable({
            url: '{{ route('admin.translations.type.get-data', [$type]) }}',
        });
    </script>
@endsection
