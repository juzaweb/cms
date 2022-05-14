@extends('cms::layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if($type == 'cms')
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Update CMS</h5>
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
                            <h5 class="card-title">Update Theme <b>{{ $theme }}</b></h5>
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
        </div>
    </div>

    <script type="text/javascript">
        $(document).on("turbolinks:load", function() {
            @if($type == 'cms')
            jwCMSUpdate("{{ $type }}", 1, '#cms-update-process');
            @endif

            @if($type == 'theme')
            var themes = @json($themes);
            var updateIndex = 0;

            recursiveUpdate("{{ $type }}", themes, updateIndex);
            @endif
        });
    </script>
@endsection
