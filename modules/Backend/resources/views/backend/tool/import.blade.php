@extends('cms::layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-12">

            <h5>{{ __('Import From Blogger') }}</h5>

            <form action="" method="post" class="form-import">
                @csrf

                <input type="hidden" name="type" value="blogger">

                <div class="progress mt-3 box-hidden form-progress">
                    <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 0" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <div class="form-inputs">
                    <div class="form-group form-url">
                        <label class="col-form-label" for="url">File</label>
                        <div class="row">
                            <div class="col-md-4">
                                <span id="file-name"></span>
                                <input type="hidden" name="file" id="url" class="form-control" autocomplete="off" value="">
                            </div>

                            <div class="col-md-2">
                                <a href="javascript:void(0)" class="btn btn-primary file-manager" data-input="url" data-type="file" data-name="file-name"><i class="fa fa-upload"></i> Choose File</a>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Import</button>
                </div>
            </form>

            <h5 class="mt-5">{{ __('Import From Wordpress') }}</h5>

            <form action="" method="post" class="form-import">
                @csrf

                <input type="hidden" name="type" value="wordpress">

                <div class="progress mt-3 box-hidden form-progress">
                    <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 0" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <div class="form-inputs">
                    <div class="form-group form-url">
                        <label class="col-form-label" for="wordpress-url">File</label>
                        <div class="row">
                            <div class="col-md-4">
                                <span id="wordpress-file-name"></span>
                                <input type="hidden" name="file" id="wordpress-url" class="form-control" autocomplete="off" value="">
                            </div>

                            <div class="col-md-2">
                                <a href="javascript:void(0)" class="btn btn-primary file-manager" data-input="wordpress-url" data-type="file" data-name="wordpress-file-name"><i class="fa fa-upload"></i> Choose File</a>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Import</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function setProgress(parent, percent) {
            parent.find('.form-progress .progress-bar')
                .text(percent + '%')
                .css('width', percent +'%')
                .attr('aria-valuenow', percent);
        }

        function requestImport(url, data, parent) {
            ajaxRequest(url, data, {
                callback: function (response) {
                    if (response.data.next) {
                        setProgress(
                            parent,
                            Math.round(
                                (response.data.next.next_page / response.data.next.max_page) * 100
                            )
                        );
                        requestImport(url, data, parent);
                    } else {
                        setProgress(parent, 100);
                        show_message(response);
                    }
                },
                failCallback: function (response) {
                    setProgress(parent, 0);
                    show_message(response);
                }
            });
        }

        $('.form-import').on('submit', function (event) {
            if (event.isDefaultPrevented()) {
                return false;
            }

            event.preventDefault();

            var file = $(this).find('input[name=file]').val();
            var type = $(this).find('input[name=type]').val();

            if (!file || !type) {
                return false;
            }

            //$(this).find('.form-inputs').hide('slow');
            //$(this).find('.form-progress').show('slow');

            requestImport("", {file: file, type: type}, $(this));
            return false;
        });
    </script>

@endsection
