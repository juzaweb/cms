@extends('cms::layouts.backend')

@section('content')
    <div class="row mb-2">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <div class="btn-group float-right">
                @if(config('juzaweb.plugin.enable_upload'))
                    <a href="{{ route('admin.plugin.install') }}" class="btn btn-success" data-turbolinks="false"><i class="fa fa-plus-circle"></i> {{ trans('cms::app.add_new') }}</a>
                @endif
            </div>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-3">
            <form method="post" class="form-inline">
                @csrf
                <select name="bulk_actions" id="bulk-actions" class="form-control w-60 mb-2 mr-1">
                    <option value="">{{ trans('cms::app.bulk_actions') }}</option>
                    <option value="activate">{{ trans('cms::app.activate') }}</option>
                    <option value="deactivate">{{ trans('cms::app.deactivate') }}</option>
                    @if(config('juzaweb.plugin.enable_upload'))
                    <option value="delete">{{ trans('cms::app.delete') }}</option>
                    @endif
                </select>

                <button type="submit" class="btn btn-primary px-2 mb-2" id="apply-action">{{ trans('cms::app.apply') }}</button>
            </form>
        </div>

        <div class="col-md-9">
            <form method="get" class="form-inline" id="form-search">
                <div class="form-group mb-2 mr-1">
                    <label for="search" class="sr-only">{{ trans('cms::app.search') }}</label>
                    <input name="search" type="text" id="search" class="form-control" placeholder="{{ trans('cms::app.search') }}" autocomplete="off">
                </div>

                <div class="form-group mb-2 mr-1">
                    <label for="status" class="sr-only">{{ trans('cms::app.status') }}</label>
                    <select name="status" id="status" class="form-control select2-default">
                        <option value="">{{ trans('cms::app.all_status') }}</option>
                        <option value="1">{{ trans('cms::app.enabled') }}</option>
                        <option value="0">{{ trans('cms::app.disabled') }}</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mb-2">{{ trans('cms::app.search') }}</button>
            </form>
        </div>
    </div>

    <div class="table-responsive mb-5">
        <table class="table jw-table juzaweb-table">
            <thead>
                <tr>
                    <th data-width="3%" data-field="state" data-checkbox="true"></th>
                    <th data-field="name" data-width="25%" data-formatter="nameFormatter">{{ trans('cms::app.name') }}</th>
                    <th data-field="description">{{ trans('cms::app.description') }}</th>
                    <th data-field="version" data-width="10%">{{ trans('cms::app.version') }}</th>
                    <th data-width="15%" data-field="status" data-formatter="statusFormatter" data-align="center">{{ trans('cms::app.status') }}</th>
                </tr>
            </thead>
        </table>
    </div>

    <script type="text/javascript">
        function nameFormatter(value, row, index) {
            let str = `<div class="font-weight-bold">${value}</div>`;

            str += `<ul class="list-inline mb-0 list-actions mt-2 ">`;

            if(row.status == 'active') {
                str += `<li class="list-inline-item"><a href="javascript:void(0)" class="jw-table-row action-item" data-id="${row.id}" data-action="deactivate">${juzaweb.lang.deactivate}</a></li>`;
            } else {
                str += `<li class="list-inline-item"><a href="javascript:void(0)" class="jw-table-row action-item" data-id="${row.id}" data-action="activate">${juzaweb.lang.activate}</a></li>`;
            }

            if (row.setting && row.status == 'active') {
                str += `<li class="list-inline-item"><a href="${juzaweb.adminUrl +'/'+row.setting}" class="jw-table-row">${juzaweb.lang.setting}</a></li>`;
            }

            @if(config('juzaweb.plugin.enable_upload'))
            if (row.update) {
                str += `<li class="list-inline-item"><a href="javascript:void(0)" class="jw-table-row action-item" data-id="${row.id}" data-action="update">${juzaweb.lang.update}</a></li>`;
            }

            str += `<li class="list-inline-item"><a href="javascript:void(0)" class="jw-table-row text-danger action-item" data-id="${row.id}" data-action="delete">${juzaweb.lang.delete}</a></li>`;
            @endif
            str += `</ul>`;
            return str;
        }

        function statusFormatter(value, row, index) {
            switch (value) {
                case 'inactive':
                    return `<span class='text-disable'>${juzaweb.lang.inactive}</span>`;
            }

            return `<span class='text-success'>${juzaweb.lang.active}</span>`;
        }

        var table = new JuzawebTable({
            url: '{{ route('admin.plugin.get-data') }}',
            action_url: '{{ route('admin.plugin.bulk-actions') }}',
            chunk_action: true
        });
    </script>
@endsection
