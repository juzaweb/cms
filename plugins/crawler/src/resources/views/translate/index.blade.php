@extends('cms::layouts.backend')

@section('header')
    <script type="text/javascript">
        var tacction_url = {
            'retranslate': '{{ route('backend.leech.translate.retranslate', [$content->id]) }}',
        };
    </script>
@endsection

@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-0 card-title font-weight-bold">{{ $title }}</h5>
                </div>

                <div class="col-md-6">
                    <div class="float-right form-inline">
                        <div class="form-inline mr-2">
                            <select id="status-value" class="form-control">
                                <option value="">Status</option>
                                <option value="1">Success</option>
                                <option value="0">Error</option>
                                <option value="2">Pending</option>
                            </select>
                            <button type="button" class="btn btn-danger btn-sm" id="status-button"><i class="fa fa-check-circle"></i> Apply</button>
                        </div>

                        <div class="btn-group">
                            <a href="" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> Add New</a>
                            <button type="button" class="btn btn-danger btn-sm" id="delete-item"><i class="fa fa-trash"></i> Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-12">
                    <form method="get" class="form-inline" id="form-search">
                        <div class="form-group mb-2 mr-1">
                            <label class="sr-only">Search</label>
                            <input name="search" type="text" class="form-control" placeholder="Search" autocomplete="off">
                        </div>

                        <div class="form-group mb-2 mr-1">
                            <label class="sr-only">Status</label>
                            <select name="status" class="form-control">
                                <option value="">Status</option>
                                <option value="1">Success</option>
                                <option value="0">Error</option>
                                <option value="2">Pending</option>
                                <option value="3">Retranslate</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search"></i> Search</button>
                    </form>
                </div>
            </div>

            <div class="table-responsive mb-5">
                <table class="table load-bootstrap-table">
                    <thead>
                        <tr>
                            <th data-width="3%" data-field="state" data-checkbox="true"></th>
                            <th data-field="post_title">Post title</th>
                            <th data-field="lang_name" data-width="15%">Language</th>
                            <th data-field="error" data-width="15%">Error</th>
                            <th data-field="status" data-width="10%" data-align="center" data-formatter="status_formatter">Status</th>
                            <th data-field="action" data-width="10%" data-align="center" data-formatter="action_formatter">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function url_formatter(value, row, index) {
        return '<a href="'+ row.url +'" target="_blank">'+ row.url +'</a>';
    }

    function status_formatter(value, row, index) {
        let status = parseInt(row.status);
        switch (status) {
            case 0: return '<span class="text-danger">Error</span>';
            case 1: return '<span class="text-success">Success</span>';
            case 2: return '<span class="text-warning">Translating</span>';
            case 3: return '<span class="text-warning">Retranslate</span>';
        }
    }

    function action_formatter(value, row, index) {
        let str = '';
        str += '<a href="javascript:void(0)" class="btn btn-warning btn-sm mr-1 retranslate" title="Releech Translate" data-id="'+ row.id +'"><i class="fa fa-refresh"></i></a>';
        return str;
    }

    var table = new JuzawebTable({
        url: '{{ route('backend.leech.translate.getdata', [$content->id]) }}',
        remove_url: '{{ route('backend.leech.translate.remove', [$content->id]) }}',
        status_url: '{{ route('backend.leech.translate.publish', [$content->id]) }}',
    });
</script>
@endsection