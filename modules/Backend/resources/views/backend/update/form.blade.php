@extends('cms::layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if($type == 'cms')
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('Update CMS') }}</h5>
                    </div>

                    <div class="card-body">
                        <div id="cms-update-process">
                            <div class="progress mb-3">
                                <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 0" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <ul class="process-text" style="list-style: unset;">

                            </ul>
                        </div>

                    </div>
                </div>
            @endif

            @if($type == 'theme')
                @foreach($themes as $theme)
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">{{ $action == 'update' ? 'Update' : 'Install' }} Theme <b>{{ $theme }}</b></h5>
                        </div>

                        <div class="card-body">
                            <div id="theme-{{ $theme }}-update-process">
                                <div class="progress mb-3">
                                    <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 0" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>

                                <ul class="process-text" style="list-style: unset;">

                                </ul>
                            </div>

                        </div>
                    </div>
                @endforeach
            @endif

            @if($type == 'plugin')
                @foreach($plugins as $plugin)
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">{{ $action == 'update' ? 'Update' : 'Install' }} Plugin <b>{{ $plugin }}</b></h5>
                        </div>

                        <div class="card-body">
                            <div id="plugin-{{ str_replace('/', '_', $plugin) }}-update-process">
                                <div class="progress mb-3">
                                    <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 0" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>

                                <ul class="process-text" style="list-style: unset;">

                                </ul>
                            </div>

                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            @if($type == 'cms')
            jwCMSUpdate(
                "{{ $type }}",
                1,
                '#cms-update-process',
                {},
                function(response) {
                    let referren = "{{ route('admin.update') }}";
                    let params = {
                        response: response,
                        referren: referren,
                        type: "{{ $type }}"
                    };

                    ajaxRequest("{{ route('admin.update.success') }}", params, {
                        method: 'POST',
                        callback: function (response) {
                            window.location = referren;
                        },
                        failCallback: function (response) {
                            show_message(response);
                        }
                    });
                }
            );
            @endif

            @if($type == 'theme')
            var themes = @json($themes);
            var updateIndex = 0;

            recursiveUpdate("{{ $type }}", themes, updateIndex, function(response) {
                let referren = "{{ $referren ?: route('admin.themes') }}";
                let params = {
                    response: response,
                    referren: referren,
                    type: "{{ $type }}"
                };

                ajaxRequest("{{ route('admin.update.success') }}", params, {
                    method: 'POST',
                    callback: function (response) {
                        window.location = referren;
                    },
                    failCallback: function (response) {
                        show_message(response);
                    }
                });
            });
            @endif

            @if($type == 'plugin')
            var plugins = @json($plugins);
            var updateIndex = 0;

            recursiveUpdate("{{ $type }}", plugins, updateIndex, function(response) {
                let referren = "{{ $referren ?: route('admin.plugin') }}";
                let params = {
                    response: response,
                    referren: referren,
                    type: "{{ $type }}"
                };

                ajaxRequest("{{ route('admin.update.success') }}", params, {
                    method: 'POST',
                    callback: function (response) {
                        window.location = referren;
                    },
                    failCallback: function (response) {
                        show_message(response);
                    }
                });
            });
            @endif
        });
    </script>
@endsection
