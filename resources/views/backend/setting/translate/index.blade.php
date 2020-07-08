@extends('layouts.backend')

@section('title', trans('app.translate'))

@section('content')

{{ Breadcrumbs::render('multiple_parent', [
    [
        'name' => trans('app.language'),
        'url' => route('admin.languages')
    ],
    [
        'name' => trans('app.translate'),
        'url' => route('admin.translate', ['lang' => $lang])
    ]
]) }}

<div class="cui__utils__content">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-0 card-title font-weight-bold">@lang('app.translate')</h5>
                </div>

                <div class="col-md-6">
                    <div class="btn-group float-right">

                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-12">
                    <form method="get" class="form-inline" id="form-search">

                        <div class="form-group mb-2 mr-1">
                            <label for="inputName" class="sr-only">@lang('app.search')</label>
                            <input name="search" type="text" id="inputName" class="form-control" placeholder="@lang('app.search')" autocomplete="off">
                        </div>

                        <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search"></i> @lang('app.search')</button>
                    </form>
                </div>

            </div>

            <div class="table-responsive mb-5">
                <table class="table load-bootstrap-table">
                    <thead>
                        <tr>
                            <th data-width="35%" data-field="en">English</th>
                            <th data-field="{{ $lang }}" data-formatter="translate_formatter">@lang('app.translate')</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
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

        var table = new LoadBootstrapTable({
            url: '{{ route('admin.translate.getdata', ['lang' => $lang]) }}',
        });

        $(document).on('change', '.text-trans', function () {

            let key = $(this).data('key');
            let value = $(this).val();

            $.ajax({
                type: 'POST',
                url: '{{ route('admin.translate.save', ['lang' => $lang]) }}',
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
                show_message(langs.data_error, 'error');
                return false;
            });
        });
    </script>
@endsection