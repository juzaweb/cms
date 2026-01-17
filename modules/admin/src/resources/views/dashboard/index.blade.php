@extends('core::layouts.admin')

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/plugins/chartjs/Chart.min.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
            <span class="info-box-icon bg-primary elevation-1">
                <i class="fas fa-layer-group"></i>
            </span>

                <div class="info-box-content">
                    <span class="info-box-text">{{ __('core::translation.pages') }}</span>
                    <span class="info-box-number">{{ number_human_format($totalPages) }}</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1">
                <i class="fas fa-users"></i>
            </span>

                <div class="info-box-content">
                    <span class="info-box-text">{{ __('core::translation.members') }}</span>
                    <span class="info-box-number">{{ number_human_format($totalUsers) }}</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1">
                    <i class="fas fa-user"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">{{ __('core::translation.online') }}</span>
                    <span class="info-box-number" id="online-count">{{ number_human_format(online_count()) }}</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1">
                    <i class="fas fa-database"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">{{ __('core::translation.storage') }}</span>
                    <span class="info-box-number">{{ format_size_units($usedStorage) }}</span>
                    <div>
                        <small class="text-muted" style="opacity: 0.9;">
                            / {{ format_size_units($storageFree) }}
                        </small>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @do_action('admin.dashboard.index')

    <div class="row">
        <div class="col-md-8">
            {{ \Juzaweb\Modules\Core\Support\Dashboard\UsersChart::make()->render() }}
        </div>

        <div class="col-md-4">
            {{ Chart::make('users-by-country')->render() }}
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8">
            {{ Chart::make('session-duration')->render() }}
        </div>

        <div class="col-md-4">
            {{ Chart::make('sessions-by-device')->render() }}
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8">
            {{ Chart::make('top-pages')->render() }}
        </div>

        <div class="col-md-4">
            {{ Chart::make('traffic-sources')->render() }}
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ url('plugins/chartjs/Chart.min.js') }}"></script>
    <script type="text/javascript" nonce="{{ csp_script_nonce() }}">
        function updateOnlineCount() {
            $.ajax({
                url: "{{ route('admin.dashboard.online-count') }}",
                type: "GET",
                dataType: "json",
                success: function (response) {
                    $('#online-count').text(response.total);
                },
                error: function (xhr) {
                    console.error('Failed to load online count', xhr);
                }
            });
        }

        $(function () {
            setInterval(updateOnlineCount, 60000);
        });
    </script>
@endsection
