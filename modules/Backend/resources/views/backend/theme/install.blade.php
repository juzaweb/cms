@extends('cms::layouts.backend')

@section('content')

    <div class="row">
        <div class="col-md-8">

        </div>
    </div>

    <div class="row" id="theme-list"></div>

    <template id="theme-template">
        <div class="col-md-4">
            <div class="card">
                <div class="height-200 d-flex flex-column jw__g13__head" style="background-image: url('{screenshot}')">
                </div>

                <div class="card card-borderless mb-0">
                    <div class="card-header border-bottom-0">
                        <div class="d-flex">
                            <div class="text-dark text-uppercase font-weight-bold mr-auto">
                                {title}
                            </div>
                            <div class="text-gray-6">
                                <button class="btn btn-primary install-theme" data-theme="{name}"> {{ trans('cms::app.install') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <script>
        var listView = new JuzawebListView({
            url: "{{ route('admin.theme.install.all') }}",
            list: "#theme-list",
            template: "theme-template",
            page_size: 9,
        });
    </script>
@endsection
