<div class="row mb-3">
    @if($actions)
        <div class="col-md-4">
            <form method="post" class="form-inline">
                @csrf

                <select name="bulk_actions" class="form-control select2-default" data-width="120px">
                    <option value="">{{ trans('cms::app.bulk_actions') }}</option>
                    @foreach($actions as $key => $action)
                        <option value="{{ $key }}">{{ is_array($action) ? $action['label'] : $action }}</option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-primary px-3" id="apply-action">{{ trans('cms::app.apply') }}</button>
            </form>
        </div>
    @endif

    <div class="col-md-8">
        <form method="get" class="form-inline" id="form-search">
            @foreach($searchFields as $name => $field)
                {{ $searchFieldTypes[$field['type']]['view']
                    ->with([
                        'name' => $name,
                        'field' => $field
                    ])
                    }}
            @endforeach

            <button type="submit" class="btn btn-primary mb-2">
                <i class="fa fa-search"></i> {{ trans('cms::app.search') }}
            </button>
        </form>
    </div>
</div>

<div class="table-responsive">
    <table class="table jw-table" id="{{ $uniqueId }}">
        <thead>
            <tr>
                <th data-width="3%" data-checkbox="true"></th>
                @foreach($columns as $key => $column)
                    <th
                        data-width="{{ $column['width'] ?? 'auto' }}"
                        data-align="{{ $column['align'] ?? 'left' }}"
                        data-field="{{ $key }}"
                        data-sortable="{{ $column['sortable'] ?? true }}"
                    >{{
                                $column['label'] ?? strtoupper($key) }}
                    </th>
                @endforeach
            </tr>
        </thead>
    </table>
</div>

@php
    $dataUrl = $dataUrl ?: route('admin.datatable.get-data') .'?table='. urlencode($table) .'&data='. urlencode(json_encode($params)) .'&currentUrl='. url()->current();
    $actionUrl = $actionUrl ?: route('admin.datatable.bulk-actions') .'?table='. urlencode($table) .'&data='. urlencode(json_encode($params)) .'&currentUrl='. url()->current();
@endphp

<script type="text/javascript">
    var table = new JuzawebTable({
        table: "#{{ $uniqueId }}",
        page_size: parseInt("{{ $perPage }}"),
        sort_name: "{{ $sortName }}",
        sort_order: "{{ $sortOder }}",
        url: '{{ $dataUrl }}',
        action_url: '{{ $actionUrl }}'
    });
</script>
