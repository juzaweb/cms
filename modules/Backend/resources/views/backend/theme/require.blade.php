@extends('cms::layouts.backend')

@section('content')
    <div class="row mb-3">
        <div class="col-md-4">
            <form method="post" class="form-inline">
                @csrf

                <select name="bulk_actions" class="form-control select2-default" data-width="120px">
                    <option value="">{{ trans('cms::app.bulk_actions') }}</option>
                    <option value="activate">{{ trans('cms::app.active') }}</option>
                    @if(config('juzaweb.plugin.enable_upload'))
                        <option value="install">{{ trans('cms::app.install') }}</option>
                    @endif
                </select>

                <button type="submit" class="btn btn-primary px-3" id="apply-action">{{ trans('cms::app.apply') }}</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive mb-5">
                <table class="table juzaweb-table">
                    <thead>
                        <tr>
                            <th data-field="state" data-width="3%" data-checkbox="true"></th>
                            <th data-field="key">{{ trans('cms::app.code') }}</th>
                            <th data-field="version" data-width="10%">{{ trans('cms::app.version') }}</th>
                            <th data-field="status" data-width="10%" data-formatter="status_formatter">{{ trans('cms::app.status') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function status_formatter(value, row, index) {
            switch (value) {
                case 'installed':
                    return `<span class="text-success">${juzaweb.lang.installed}</span>`;
            }

            return `<span class="text-secondary">${juzaweb.lang.not_installed}</span>`;
        }

        var table = new JuzawebTable({
            url: "{{ route('admin.themes.require-plugins.get-data') }}",
            action_url: "{{ route('admin.plugin.bulk-actions') }}"
        });
    </script>
@endsection
