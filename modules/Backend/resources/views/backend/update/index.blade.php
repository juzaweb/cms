@extends('cms::layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                <p>{{ __('You are using Juzaweb CMS Version') }}: {{ \Juzaweb\CMS\Version::getVersion() }}</p>
                <p>
                    <a href="https://github.com/juzaweb/cms/releases" target="_blank">{{ __('View change logs here') }}</a>. <a href="https://juzaweb.com/documentation/start/update" target="_blank">{{ __('View update guide here') }}</a>
                </p>
            </div>

            <div id="update-form">
                <img src="{{ asset('themes/default/assets/images/loader.gif') }}" alt="">
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <h5>{{ __('Update plugins') }}</h5>
            <div class="row mb-2">
                <div class="col-md-4">
                    <form method="post" class="form-inline">
                        @csrf

                        <select name="bulk_actions" class="form-control select2-default" data-width="120px">
                            <option value="">{{ trans('cms::app.bulk_actions') }}</option>
                            <option value="update">{{ trans('cms::app.update') }}</option>
                        </select>

                        <button type="submit" class="btn btn-primary px-3" id="apply-action-plugins">{{ trans('cms::app.apply') }}</button>
                    </form>
                </div>
            </div>

            <div class="table-responsive mb-5">
                <table class="table" id="plugins-table">
                    <thead>
                        <tr>
                            <th data-field="state" data-width="3%" data-checkbox="true"></th>
                            <th data-field="plugin">{{ trans('cms::app.plugin') }}</th>
                            <th data-field="current_version" data-width="10%">{{ trans('cms::app.current_version') }}</th>
                            <th data-field="new_version" data-width="10%">{{ trans('cms::app.new_version') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-12">
            <h5>{{__('Update themes')}}</h5>
            <div class="row mb-2">
                <div class="col-md-4">
                    <form method="post" class="form-inline">
                        @csrf

                        <select name="bulk_actions" class="form-control select2-default" data-width="120px">
                            <option value="">{{ trans('cms::app.bulk_actions') }}</option>
                            <option value="update">{{ trans('cms::app.update') }}</option>
                        </select>

                        <button type="submit" class="btn btn-primary px-3" id="apply-action-themes">{{ trans('cms::app.apply') }}</button>
                    </form>
                </div>
            </div>

            <div class="table-responsive mb-5">
                <table class="table" id="themes-table">
                    <thead>
                        <tr>
                            <th data-field="state" data-width="3%" data-checkbox="true"></th>
                            <th data-field="theme">{{ trans('cms::app.theme') }}</th>
                            <th data-field="current_version" data-width="10%">{{ trans('cms::app.current_version') }}</th>
                            <th data-field="new_version" data-width="10%">{{ trans('cms::app.new_version') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function update_success() {
            setTimeout(function () {
                window.location = "";
            }, 300);
            return false;
        }

        var table1 = new JuzawebTable({
            table: "#plugins-table",
            apply_button: "#apply-action-plugins",
            url: "{{ route('admin.update.plugins') }}",
            action_url: "{{ route('admin.plugin.bulk-actions') }}"
        });

        var table2 = new JuzawebTable({
            table: "#themes-table",
            apply_button: "#apply-action-themes",
            url: "{{ route('admin.update.themes') }}",
            action_url: "{{ route('admin.themes.bulk-actions') }}"
        });

        ajaxRequest("{{ route('admin.update.check') }}", {}, {
            method: 'GET',
            callback: function (response) {
                $('#update-form').html(response.html);
            }
        })
    </script>
@endsection
