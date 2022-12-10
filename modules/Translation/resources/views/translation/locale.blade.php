@extends('cms::layouts.backend')

@section('content')
    <div class="row mb-2">
        <div class="col-md-12">
            <div class="row mb-2">
                <div class="col-md-8">
                    <form method="get" class="form-inline" id="form-search">
                        <div class="form-group mb-2 mr-1">
                            <label for="search" class="sr-only">@lang('cms::app.search')</label>
                            <input name="search" type="text" id="search" class="form-control" placeholder="{{ trans('cms::app.search') }}" autocomplete="off">
                        </div>

                        <button type="submit" class="btn btn-primary mb-2">@lang('cms::app.search')</button>
                    </form>
                </div>
            </div>

            <div class="table-responsive mb-5">
                <table class="table juzaweb-table">
                    <thead>
                        <tr>
                            <th data-field="index" data-width="3%" data-formatter="index_formatter" data-align="center">#</th>
                            <th data-field="value" data-width="35%" data-formatter="origin_formatter">{{ trans('cms::app.origin') }}</th>
                            <th data-formatter="translate_formatter">{{ trans('cms::app.your_value') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function index_formatter(value, row, index) {
            return (index + 1);
        }

        function origin_formatter(value, row, index) {
            return `<span title="${row.key}">${row.value}</span>`;
        }

        function translate_formatter(value, row, index) {
            return `<input class="form-control trans-input" value="${row.trans}" data-key="${row.key}" data-group="${row.group}">`;
        }

        let table = new JuzawebTable({
            url: '{{ route('admin.translations.locale.get-data', [$type, $locale]) }}',
        });

        $(document).on('change', '.trans-input', function () {
            let key = $(this).data('key');
            let group = $(this).data('group');
            let value = $(this).val();

            $.ajax({
                type: 'POST',
                url: '{{ route('admin.translations.locale.save', [$type, $locale]) }}',
                dataType: 'json',
                data: {
                    'key': key,
                    'value': value,
                    'group': group,
                }
            }).done(function(response) {
                if (response.status === false) {
                    show_message(response);
                    return false;
                }

                return false;
            }).fail(function(response) {
                show_message(response);
                return false;
            });
        });
    </script>
@endsection
