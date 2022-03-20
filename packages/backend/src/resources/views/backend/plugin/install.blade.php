@extends('cms::layouts.backend')

@section('content')

    <div class="row">
        <div class="col-md-8">

        </div>
    </div>

    <div class="row" id="plugin-list"></div>

    <template id="plugin-template">
        <div class="col-md-4">
            <div class="card p-3">
                <div class="d-flex flex-row mb-3">
                    <img src="{thumbnail}" alt="" width="70" height="70">
                    <div class="d-flex flex-column ml-2">
                        <span>{title}</span>
                        {{--<span class="text-black-50">Payment Services</span>--}}

                        <span class="ratings text-secondary">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </span>
                    </div>
                </div>
                <h6>{description}</h6>
                <div class="d-flex justify-content-between install mt-3">
                    {{--<span>Installed 172 times</span>--}}
                    <button class="btn btn-primary install-plugin" data-plugin="{code}">{{ trans('cms::app.install') }}</button>

                    {{--<a target="_blank" href="{url}" class="text-primary">
                        {{ trans('cms::app.view') }}&nbsp;<i class="fa fa-angle-right"></i>
                    </a>--}}
                </div>
            </div>
        </div>
    </template>

    <script>
        var listView = new JuzawebListView({
            url: "{{ route('admin.plugin.install.all') }}",
            list: "#plugin-list",
            template: "plugin-template"
        });
    </script>
@endsection