@extends('cms::layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Update CMS</h5>
                </div>

                <div class="card-body">
                    <div id="update-process">
                        <div class="progress mb-3">
                            <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 0" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <ul class="process-text" style="list-style: unset;">

                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).on("turbolinks:load", function() {
            jwCMSUpdate('cms', 1, '#update-process');
        });
    </script>
@endsection
