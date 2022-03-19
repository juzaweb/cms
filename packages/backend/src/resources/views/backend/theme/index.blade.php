@extends('cms::layouts.backend')

@section('content')

    <div class="row" id="theme-list">
        @if($currentTheme)
        <div class="col-md-4">
            <div class="card">
                <div class="height-200 d-flex flex-column jw__g13__head" style="background-image: url('{{ $currentTheme->getThumbnail() }}')">
                </div>

                <div class="card card-borderless mb-0">
                    <div class="card-header border-bottom-0">
                        <div class="d-flex">
                            <div class="text-dark text-uppercase font-weight-bold mr-auto">
                                {{ $currentTheme->title }}
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
        <div class="col-md-4">
            <div class="card">
                <div class="height-200 d-flex flex-column jw__g13__head" style="background-image: url('{thumbnail}')">
                </div>

                <div class="card card-borderless mb-0">
                    <div class="card-header border-bottom-0">
                        <div class="d-flex">
                            <div class="text-dark text-uppercase font-weight-bold mr-auto">
                                {title}
                            </div>
                            <div class="text-gray-6">
                                <button class="btn btn-primary active-theme" data-theme="{code}"> {{ trans('cms::app.activate') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <script>
        setTimeout(function () {
            var listView = new JuzawebListView({
                url: "{{ route('admin.themes.get-data') }}",
                list: "#theme-list",
                template: "theme-template",
                page_size: 9,
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