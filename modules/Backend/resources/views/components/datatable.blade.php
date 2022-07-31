<div class="row">
    @if($actions)
        <div class="col-md-2">
            <form method="post" class="form-inline">
                @csrf

                <div class="dropdown d-inline-block mb-2 mr-2">
                    <button type="button" class="btn btn-primary dropdown-toggle bulk-actions-button" data-toggle="dropdown" aria-expanded="false">
                        {{ trans('cms::app.bulk_actions') }}
                    </button>
                    <div class="dropdown-menu bulk-actions-actions" role="menu" x-placement="bottom-start">
                        @foreach($actions as $key => $action)
                            <a class="dropdown-item select-action action-{{$key}} @if($key == 'delete') text-danger @endif" href="javascript:void(0)" data-action="{{ $key }}">{{ is_array($action) ? $action['label'] : $action }}</a>
                        @endforeach
                    </div>
                </div>
            </form>
        </div>
    @endif

    @php
    $hasDetailFormater = collect($columns)->whereNotNull('detailFormater')->isNotEmpty();
    @endphp
    <div class="col-md-10">
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
    <table
        class="table jw-table"
        id="{{ $uniqueId }}"
        @if($hasDetailFormater)
        data-detail-view="true"
        data-detail-formatter="detailFormater"
        @endif
    >
        <thead>
            <tr>
                <th data-width="3%" data-checkbox="true"></th>
                @foreach($columns as $key => $column)
                    <th
                        data-width="{{ $column['width'] ?? 'auto' }}"
                        data-align="{{ $column['align'] ?? 'left' }}"
                        data-field="{{ $key }}"
                        data-sortable="{{ $column['sortable'] ?? true }}"
                        @if(in_array($key, $escapes))
                            data-escape="true"
                        @endif
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
    @if (!empty($hasDetailFormater))
    function detailFormater(index, row)
    {
        return row.detailFormater;
    }
    @endif

    var table = new JuzawebTable({
        table: "#{{ $uniqueId }}",
        page_size: parseInt("{{ $perPage }}"),
        sort_name: "{{ $sortName }}",
        sort_order: "{{ $sortOder }}",
        url: '{{ $dataUrl }}',
        action_url: '{{ $actionUrl }}'
    });
</script>
