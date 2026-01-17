@extends('core::layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @can('posts.create')
                <a href="{{ admin_url('posts/create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> {{ __('core::translation.add_post') }}
                </a>
            @endcan
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            @component('core::components.datatables.filters')
                <div class="col-md-3 jw-datatable_filters">
                    {{ Field::select(__('core::translation.status'), 'status')->dropDownList(
                        [
                            '' => __('core::translation.all'),
                        ]
                    )->selected(request('status')) }}
                </div>
            @endcomponent
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('core::translation.posts') }}</h3>
                </div>
                <div class="card-body">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{ $dataTable->scripts(null, ['nonce' => csp_script_nonce()]) }}
@endsection
