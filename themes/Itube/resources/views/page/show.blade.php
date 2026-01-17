@extends('itube::layouts.main')

@section('title', $title)

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-lg-auto d-none d-xl-block">
                @include('itube::components.sidebar', ['active' => 'search'])
            </div>
            <div class="col-lg">
                <div class="max-w-md-1160 ml-auto my-6 mb-lg-8 pb-lg-1">
                    <!-- Search Header -->
                    <div class="mb-4">
                        <h4 class="font-weight-medium text-gray-700">
                            {{ $title }}
                        </h4>
                    </div>

                    <section>
                        <div class="row mx-n2 mb-md-4 pb-md-1">
                            {!! $page->renderContent() !!}
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
