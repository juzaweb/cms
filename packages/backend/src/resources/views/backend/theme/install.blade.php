@extends('cms::layouts.backend')

@section('content')

    <div class="row">
        <div class="col-md-8">

        </div>
    </div>

    <div class="row" id="theme-list"></div>

    <template id="theme-template">
        <div class="col-md-4">
            {content}
        </div>
    </template>

    <script>
        var listView = new JuzawebListView({
            url: "{{ route('admin.themes.install.all') }}",
            list: "#theme-list",
            template: "theme-template",
            page_size: 9,
        });
    </script>
@endsection