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
                            <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 0" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <ul class="process-text" style="list-style: unset;">

                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var cmsUpdateUrl = "{{ route('admin.update.step', ['cms', '__STEP__']) }}";

        function jwUpdateProcess(parentElement, message = null, percent = 0, status = 'primary')
        {
            if (message) {
                $(`${parentElement} .process-text`).append(`<li class="text-${status}">${message}</li>`);
            }

            if (percent) {
                $(`${parentElement} .progress-bar`).text(percent + '%').css('width', percent + '%');
            }
        }

        function jwCMSUpdate(step)
        {
            jwUpdateProcess(
                '#update-process',
                juzaweb.lang.update_process['step'+step].before
            )

            ajaxRequest(cmsUpdateUrl.replace('__STEP__', step), {}, {
                method: 'POST',
                callback: function (response) {
                    if(response.status == false) {
                        jwUpdateProcess(
                            '#update-process',
                            response.data.message,
                            0,
                            'error'
                        );
                        return false;
                    }

                    if(response.data.next_url) {
                        jwUpdateProcess('#update-process', null, step * 17);
                        jwCMSUpdate(step+1);
                    } else {
                        jwUpdateProcess(
                            '#update-process',
                            juzaweb.lang.update_process.done,
                            100
                        );
                    }
                },
                failCallback: function (response) {
                    jwUpdateProcess(
                        '#update-process',
                        response.message,
                        step * 15,
                        'error'
                    );
                }
            })
        }

        $(document).on("turbolinks:load", function() {
            jwCMSUpdate(1);
        });
    </script>
@endsection
