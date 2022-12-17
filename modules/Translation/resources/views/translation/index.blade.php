@extends('cms::layouts.backend')

@section('content')
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="table-responsive mb-5">
                <table class="table juzaweb-table table-hover">
                    <thead>
                        <tr>
                            <th data-field="index" data-width="3%" data-formatter="index_formatter" data-align="center">#</th>
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
        let linkModule = "{{ route('admin.translations.type', ['__KEY__']) }}";

        function index_formatter(value, row, index) {
            return (index + 1);
        }

        function actions_formatter(value, row, index) {
            return `<a href="${linkModule.replace('__KEY__', row.key)}" class="btn btn-info btn-sm"><i class="fa fa-language"></i> ${juzaweb.lang.translate}</a>`;
        }

        let table = new JuzawebTable({
            url: '{{ route('admin.translations.get-data') }}',
            search: true,
        });
    </script>
@endsection
