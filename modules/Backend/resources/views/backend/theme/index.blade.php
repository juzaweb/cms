@extends('cms::layouts.backend')

@section('content')
    <div class="row mb-4">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <div class="btn-group float-right">
                @if(config('juzaweb.theme.enable_upload'))
                    <a href="{{ route('admin.theme.install') }}" class="btn btn-success" data-turbolinks="false"><i class="fa fa-plus-circle"></i> {{ trans('cms::app.add_new') }}</a>
                @endif
            </div>
        </div>
    </div>

    <div class="row" id="theme-list">
        @if($currentTheme)
        <div class="col-md-4 p-2 theme-list-item">
            <div class="card">
                <div class="height-200 d-flex flex-column jw__g13__head">
                    <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="{{ $currentTheme->get('screenshot') }}" alt="{{ $currentTheme->get('title') }}" class="lazyload w-100 h-100">
                </div>

                <div class="card card-bottom card-borderless mb-0">
                    <div class="card-header border-bottom-0">
                        <div class="d-flex">
                            <div class="text-dark text-uppercase font-weight-bold mr-auto">
                                {{ $currentTheme->get('title') }}
                            </div>
                            <div class="text-gray-6">
                                <button class="btn btn-secondary" disabled> {{ trans('cms::app.activated') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <template id="theme-template">
        <div class="col-md-4 p-2 theme-list-item">
            {content}
        </div>
    </template>

    <script>
        toggle_global_loading(true);

        setTimeout(function () {
            const listView = new JuzawebListView({
                url: "{{ route('admin.themes.get-data') }}",
                list: "#theme-list",
                template: "theme-template",
                page_size: 9,
                after_load_callback: function () {
                    toggle_global_loading(false);
                }
            });
        }, 300)
    </script>

    <script type="text/javascript">
        $('#theme-list').on('click', '.active-theme', function () {
            let btn = $(this);
            let icon = btn.find('i').attr('class');
            let theme = btn.data('theme');

            btn.find('i').attr('class', 'fa fa-spinner fa-spin');
            btn.prop("disabled", true);

            $.ajax({
                type: 'POST',
                url: "{{ route('admin.themes.activate') }}",
                dataType: 'json',
                data: {
                    theme: theme
                }
            }).done(function(response) {
                btn.find('i').attr('class', icon);
                btn.prop("disabled", false);

                if (response.status === false) {
                    show_message(response.data.message);
                    return false;
                }

                window.location = "";
                return false;
            }).fail(function(response) {
                btn.find('i').attr('class', icon);
                btn.prop("disabled", false);
                show_message(response);
                return false;
            });
        });
    </script>
@endsection
