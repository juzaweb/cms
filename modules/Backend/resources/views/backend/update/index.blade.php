@extends('cms::layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                <p>You are using Juzaweb CMS Version: {{ \Juzaweb\CMS\Version::getVersion() }}</p>
                <p>View CMS <a href="https://github.com/juzaweb/juzacms/releases" target="_blank">change logs here</a></p>
            </div>

            <div id="update-form">
                <img src="{{ asset('themes/default/assets/images/loader.gif') }}" alt="">
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <h5>Update plugins</h5>
            <div class="row mb-2">
                <div class="col-md-4">
                    <form method="post" class="form-inline">
                        @csrf

                        <select name="bulk_actions" class="form-control select2-default" data-width="120px">
                            <option value="">{{ trans('cms::app.bulk_actions') }}</option>
                            <option value="plugin">{{ trans('cms::app.update') }}</option>
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
                            <th data-field="version" data-width="15%">{{ trans('cms::app.version') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-12">
            <h5>Update themes</h5>
            <div class="row mb-2">
                <div class="col-md-4">
                    <form method="post" class="form-inline">
                        @csrf

                        <select name="bulk_actions" class="form-control select2-default" data-width="120px">
                            <option value="">{{ trans('cms::app.bulk_actions') }}</option>
                            <option value="theme">{{ trans('cms::app.update') }}</option>
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
                            <th data-field="version" data-width="15%">{{ trans('cms::app.version') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function update_success() {
            window.location = "";
            return false;
        }

        var table = new JuzawebTable({
            table: "#plugins-table",
            apply_button: "#apply-action-plugins",
            url: "{{ route('admin.update.plugins') }}",
            action_url: "",
            chunk_action: true
        });

        var table2 = new JuzawebTable({
            table: "#themes-table",
            apply_button: "#apply-action-themes",
            url: "{{ route('admin.update.themes') }}",
            action_url: "",
            chunk_action: true
        });

        ajaxRequest("{{ route('admin.update.check') }}", {}, {
            method: 'GET',
            callback: function (response) {
                $('#update-form').html(response.html);
            }
        })
    </script>
@endsection