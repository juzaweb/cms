@extends('cms::layouts.backend')

@section('content')
    <div class="row mb-2">
        <div class="col-md-12">
            <div class="row mb-2">
                <div class="col-md-8">
                    <form method="get" class="form-inline" id="form-search">
                        <div class="form-group mb-2 mr-1">
                            <label for="search" class="sr-only">@lang('cms::app.search')</label>
                            <input name="search" type="text" id="search" class="form-control" placeholder="@lang('cms::app.search')" autocomplete="off">
                        </div>

                        <button type="submit" class="btn btn-primary mb-2">@lang('cms::app.search')</button>
                    </form>
                </div>
            </div>

            <div class="table-responsive mb-5">
                <table class="table juzaweb-table">
                    <thead>
                        <tr>
                            <th data-field="value" data-width="25%" data-sortable="true">{{ trans('cms::app.origin') }}</th>
                            <th data-width="25%" data-sortable="true" data-formatter="translate_formatter">{{ trans('cms::app.your_value') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function translate_formatter(value, row, index) {
            return `<input class="form-control trans-input" value="${row.trans}" data-key="${row.key}">`;
        }

        var table = new JuzawebTable({
            url: '{{ route('admin.translations.locale.get-data', [$type, $locale]) }}',
        });

        $('body').on('change', '.trans-input', function () {
            let key = $(this).data('key');
            let value = $(this).val();

            $.ajax({
                type: 'POST',
                url: '{{ route('admin.translations.locale.save', [$type, $locale]) }}',
                dataType: 'json',
                data: {
                    'key': key,
                    'value': value
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
