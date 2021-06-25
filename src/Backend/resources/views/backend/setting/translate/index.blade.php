@extends('mymo::layouts.backend')

@section('content')

    <div class="row mb-3">
        <div class="col-md-12">
            <form method="get" class="form-inline" id="form-search">

                <div class="form-group mb-2 mr-1">
                    <label for="inputName" class="sr-only">@lang('mymo::app.search')</label>
                    <input name="search" type="text" id="inputName" class="form-control" placeholder="@lang('mymo::app.search')" autocomplete="off">
                </div>

                <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search"></i> @lang('mymo::app.search')</button>
            </form>
        </div>

    </div>

    <div class="table-responsive mb-5">
        <table class="table mymo-table">
            <thead>
            <tr>
                <th data-width="35%" data-field="en" data-sortable="true">English</th>
                <th data-field="{{ $lang }}" data-sortable="true" data-formatter="translate_formatter">@lang('mymo::app.translate')</th>
            </tr>
            </thead>
        </table>
    </div>

    <script type="text/javascript">
        function translate_formatter(value, row, index) {
            let strLang = '';
            if (value) {
                strLang = value;
            }
            else {
                strLang = row.en;
            }

            return '<input type="text" class="form-control text-trans" data-key="'+ row.key +'" value="'+ strLang +'">';
        }

        var table = new MymoTable({
            url: '{{ route('admin.setting.translate.getdata', ['lang' => $lang]) }}',
        });

        $(document).on('change', '.text-trans', function () {

            let key = $(this).data('key');
            let value = $(this).val();

            $.ajax({
                type: 'POST',
                url: '{{ route('admin.setting.translate.save', ['lang' => $lang]) }}',
                dataType: 'json',
                data: {
                    'key': key,
                    'value': value
                }
            }).done(function(data) {

                if (data.status === "error") {
                    show_message(data.message, 'error');
                    return false;
                }

                return false;
            }).fail(function(data) {
                show_message(mymo.lang.data_error, 'error');
                return false;
            });
        });
    </script>
@endsection