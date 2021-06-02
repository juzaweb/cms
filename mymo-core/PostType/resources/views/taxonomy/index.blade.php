@extends('mymo_core::layouts.backend')

@section('content')

    <div class="row">
        <div class="col-md-6"></div>

        <div class="col-md-6">
            <div class="btn-group float-right">
                <a href="{{ route('admin.' . $setting->get('type') . '.taxonomy.create', [$taxonomy]) }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> @lang('mymo_core::app.add_new')</a>
            </div>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-12">
            <div class="row mb-2">
                <div class="col-md-4">
                    <form method="post" class="form-inline">
                        <select name="bulk_actions" class="form-control w-60 mb-2 mr-1">
                            <option value="">@lang('mymo_core::app.bulk_actions')</option>
                            <option value="delete">@lang('mymo_core::app.delete')</option>
                        </select>

                        <button type="submit" class="btn btn-primary mb-2" id="apply-action">@lang('mymo_core::app.apply')</button>
                    </form>
                </div>

                <div class="col-md-8">
                    <form method="get" class="form-inline" id="form-search">
                        <div class="form-group mb-2 mr-1">
                            <label for="search" class="sr-only">@lang('mymo_core::app.search')</label>
                            <input name="search" type="text" id="search" class="form-control" placeholder="@lang('mymo_core::app.search')" autocomplete="off">
                        </div>

                        <button type="submit" class="btn btn-primary mb-2">@lang('mymo_core::app.search')</button>
                    </form>
                </div>
            </div>

            <div class="table-responsive mb-5">
                <table class="table mymo-table">
                    <thead>
                        <tr>
                            <th data-width="3%" data-field="state" data-checkbox="true"></th>
                            <th data-field="name" data-formatter="name_formatter" data-sortable="true">@lang('mymo_core::app.name')</th>
                            <th data-field="description" data-width="25%" data-sortable="true">@lang('mymo_core::app.description')</th>
                            <th data-field="total_post" data-width="10%" data-sortable="true" data-align="center">@lang('mymo_core::app.total_posts')</th>
                            <th data-width="15%" data-field="created_at" data-sortable="true">@lang('mymo_core::app.created_at')</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function name_formatter(value, row, index) {
            return '<a href="'+ row.edit_url +'">'+ value +'</a>';
        }

        var table = new MymoTable({
            url: '{{ route('admin.' . $setting->get('type') . '.taxonomy.get-data', [$taxonomy]) }}',
            action_url: '{{ route('admin.' . $setting->get('type') . '.taxonomy.bulk-actions', [$taxonomy]) }}',
        });
    </script>
@endsection
