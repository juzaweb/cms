@extends('itube::layouts.main')

@section('title', __('itube::translation.my_videos'))

@section('head')
    <link rel="stylesheet" href="{{ mix('css/profile.min.css', 'themes/itube') }}">
@endsection

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row" id="wrapper">
            @include('itube::profile.components.sidebar')

            <main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
                <h3 class="section-title">
                    <span>{{ __('itube::translation.my_videos') }}</span>
                </h3>

                {{ $dataTable->table() }}

                <div class="clearfix"></div>
            </main>

        </div>
    </div>
@endsection

@section('scripts')

    <link href="https://cdn.datatables.net/v/bs4/dt-2.3.2/datatables.min.css" rel="stylesheet" integrity="sha384-fE7frHQNLGzNl8eKcpGtCoE9nL3u5ijqXo8qfQhibuVrrUk9S+YNzm15kj8XPkJr" crossorigin="anonymous">

    <script src="https://cdn.datatables.net/v/bs4/dt-2.3.2/datatables.min.js" integrity="sha384-XCm0OMKqt/5lsXFDSL+83p4zx4Mb5SwKLZQzOW96xQUOaqaIl4x8j5ntyRAfyQl9" crossorigin="anonymous"></script>

    {{ $dataTable->scripts() }}
@endsection
