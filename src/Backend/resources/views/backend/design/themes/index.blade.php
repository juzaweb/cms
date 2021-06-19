@extends('mymo_core::layouts.backend')

@section('content')
    <div class="row" id="theme-list">
        @if($currentTheme)
        <div class="col-md-4">
            <div class="card">
                {{--<div class="height-200 d-flex flex-column kit__g13__head" style="background-image: url('{{ $currentTheme['screenshot'] ?? asset('mymo/styles/images/thumb-default.png') }}')">
                </div>--}}

                <div class="card card-borderless mb-0">
                    <div class="card-header border-bottom-0">
                        <div class="d-flex">
                            <div class="text-dark text-uppercase font-weight-bold mr-auto">
                                {{ $currentTheme['name'] }}
                            </div>
                            <div class="text-gray-6">
                                <button class="btn btn-secondary" disabled> {{ trans('mymo_core::app.activated') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @foreach($themes as $theme)
        <div class="col-md-4">
            <div class="card">
                {{--<div class="height-200 d-flex flex-column kit__g13__head" style="background-image: url('{{ $theme['screenshot'] ?? asset('mymo/styles/images/thumb-default.png') }}')">
                </div>--}}

                <div class="card card-borderless mb-0">
                    <div class="card-header border-bottom-0">
                        <div class="d-flex">
                            <div class="text-dark text-uppercase font-weight-bold mr-auto">
                                {{ $theme['name'] }}
                            </div>
                            <div class="text-gray-6">
                                <button class="btn btn-primary active-theme" data-theme="{{ $theme['name'] }}"><i class="fa fa-check"></i> {{ trans('mymo_core::app.activate') }}</button>

                                {{--<a href="javascript:void(0)" class="text-danger">{{ trans('mymo_core::app.delete') }}</a>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-md-12">
            {{ $themes->links() }}
        </div>
    </div>

    <script type="text/javascript">
        $('#theme-list').on('click', '.active-theme', function () {
            let btn = $(this);
            let icon = btn.find('i').attr('class');
            let theme = btn.data('theme');

            btn.find('i').attr('class', 'fa fa-spinner fa-spin');
            btn.prop("disabled", true);

            $.ajax({
                type: 'POST',
                url: "{{ route('admin.design.themes.activate') }}",
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