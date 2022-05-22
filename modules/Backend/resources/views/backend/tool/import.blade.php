@extends('cms::layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-12">

            <h5>{{ __('Import From Blogger') }}</h5>

            <form action="" method="post" class="form-import">
                @csrf

                <input type="hidden" name="type" value="blogger">

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
            </form>
        </div>
    </div>

    <script>
        function requestImport(url, data) {
            ajaxRequest(url, data, {
                callback: function (response) {
                    if (response.data.next) {
                        requestImport(url, data);
                    } else {
                        show_message(response);
                    }
                },
                failCallback: function (response) {
                    show_message(response);
                }
            });
        }

        $('.form-import').on('submit', function (event) {
            if (event.isDefaultPrevented()) {
                return false;
            }

            event.preventDefault();

            var file = $(this).closest('.form-import').find('input[name=file]').val();
            var type = $(this).closest('.form-import').find('input[name=type]').val();

            requestImport("", {file: file, type: type});
            return false;
        });
    </script>

@endsection
