<div class="row mb-3">
    @if($actions)
        <div class="col-md-4">
            <form method="post" class="form-inline">
                @csrf

                <div class="dropdown d-inline-block mb-2 mr-2">
                    <button type="button" class="btn btn-primary dropdown-toggle bulk-actions-button" data-toggle="dropdown" aria-expanded="false">
                        {{ trans('cms::app.bulk_actions') }}
                    </button>
                    <div class="dropdown-menu bulk-actions-actions" role="menu" x-placement="bottom-start">
                        @foreach($actions as $key => $action)
                            <a class="dropdown-item select-action action-{{$key}} @if($key == 'delete') text-danger @endif" href="javascript: void(0)" data-action="{{ $key }}">{{ is_array($action) ? $action['label'] : $action }}</a>
                        @endforeach
                    </div>
                </div>

                {{--<select name="bulk_actions" class="form-control select2-default" data-width="120px">
                    <option value="">{{ trans('cms::app.bulk_actions') }}</option>
                    @foreach($actions as $key => $action)
                        <option value="{{ $key }}">{{ is_array($action) ? $action['label'] : $action }}</option>
                    @endforeach
                </select>--}}
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
