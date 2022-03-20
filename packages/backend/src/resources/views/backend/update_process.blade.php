@extends('cms::layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>Module</th>
                        <th>Type</th>
                        <th>Process</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($processes as $process)
                        <tr>
                            <td>{{ $process->name }}</td>
                            <td>{{ $process->type }}</td>
                            <td>
                                <button class="btn btn-primary status-btn" data-id="{{ $process->id }}" disabled><i class="fa fa-spinner fa-spin"></i> Updating...</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script type="text/javascript">

        setTimeout(function(){
            checkStatus();
        }, 3000);

        function checkStatus() {

            var linkCheck = "{{ route('admin.update.process.get', ['__ID__']) }}";

            $('.status-btn:disabled').each(function() {
                let item = $(this);
                let id = item.data('id');

                $.ajax({
                    type: 'GET',
                    url: linkCheck.replace('__ID__', id),
                    dataType: 'json',
                    data: {}
                }).done(function(response) {

                    if (response.data.result === "ok") {
                        item.prop('disabled', false);
                        item.html(`<i class="fa fa-check"></i> Updated`);
                    }

                    return false;
                }).fail(function(response) {
                    show_message(response);
                    return false;
                });
            });

            setTimeout(function(){
                checkStatus();
            }, 3000);

        }
    </script>
@endsection