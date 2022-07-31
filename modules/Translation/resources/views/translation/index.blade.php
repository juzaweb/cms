@extends('cms::layouts.backend')

@section('content')
    <div class="row mb-2">
        <div class="col-md-12">
            <div class="table-responsive mb-5">
                <table class="table juzaweb-table table-hover">
                    <thead>
                        <tr>
                            <th data-field="title">{{ trans('cms::app.name') }}</th>
                            <th data-field="type" data-width="15%">{{ trans('cms::app.type') }}</th>
                            <th data-width="20%" data-formatter="actions_formatter">{{ trans('cms::app.actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var linkModule = "{{ route('admin.translations.type', ['__KEY__']) }}";

        function actions_formatter(value, row, index) {
            return `<a href="${linkModule.replace('__KEY__', row.key)}">${juzaweb.lang.translations}</a>`;
        }

        var table = new JuzawebTable({
            url: '{{ route('admin.translations.get-data') }}',
        });
    </script>
@endsection
