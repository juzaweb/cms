@extends('cms::layouts.backend')

@section('content')
    {{ $dataTable->render() }}

    <script>
        $('.jw-table').on('change', '.translate', function () {
            let text = $(this).val();
            let namespace = $(this).data('namespace');
            let group = $(this).data('group');
            let key = $(this).data('key');

            $.ajax({
                type: 'POST',
                url: "{{ route('admin.translation.lang.save', [$lang]) }}",
                dataType: 'json',
                data: {
                    text: text,
                    namespace: namespace,
                    group: group,
                    key: key,
                }
            }).done(function(response) {
                if (response.status === false) {
                    show_message(response);
                    return false;
                }

                return false;
            }).fail(function(response) {
                show_message(response);
                return false;
            });
        });
    </script>
@endsection