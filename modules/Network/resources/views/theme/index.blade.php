@extends('network::layout')

@section('content')

    <div class="row mb-3">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <div class="btn-group float-right">
                @if(config('juzaweb.theme.enable_upload'))
                    <a href="{{ route('admin.network.theme.install') }}" class="btn btn-success" data-turbolinks="false"><i class="fa fa-plus-circle"></i> {{ trans('cms::app.add_new') }}</a>
                @endif
            </div>
        </div>
    </div>

    <div class="row" id="theme-list"></div>

    <template id="theme-template">
        <div class="col-md-4 theme-list-item">
            {content}
        </div>
    </template>

    <script>
        setTimeout(function () {
            var listView = new JuzawebListView({
                url: "{{ route('admin.themes.get-data') }}?network=true",
                list: "#theme-list",
                template: "theme-template",
                page_size: 9,
            });
        }, 300)
    </script>
@endsection
