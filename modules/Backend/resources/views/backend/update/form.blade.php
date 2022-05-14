@extends('cms::layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-12">

        </div>
    </div>

    <script type="text/javascript">
        /*ajaxRequest("{{ route('admin.update.check') }}", {}, {
            method: 'GET',
            callback: function (response) {
                $('#update-form').html(response.html);
            }
        })*/
    </script>
@endsection
