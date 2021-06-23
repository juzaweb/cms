<table class="table mymo-table">
    <thead>
        <tr>
            @foreach($columns as $key => $column)
            <th data-width="10%" data-field="{{ $key }}" data-formatter="thumbnail_formatter">{{ $column['label'] ?? '' }}</th>
            @endforeach
        </tr>
    </thead>
</table>

<script type="text/javascript">
    function thumbnail_formatter(value, row, index) {
        return '<img src="'+ row.thumb_url +'" class="w-100">';
    }

    function name_formatter(value, row, index) {
        return '<a href="'+ row.edit_url +'">'+ value +'</a>';
    }

    function status_formatter(value, row, index) {
        if (value == 1) {
            return '<span class="text-success">@lang('mymo::app.enabled')</span>';
        }
        return '<span class="text-danger">@lang('mymo::app.disabled')</span>';
    }

    var table = new MymoTable({
        url: '{{ route('admin.posts.get-data') }}',
        action_url: '{{ route('admin.posts.bulk-actions') }}',
    });
</script>