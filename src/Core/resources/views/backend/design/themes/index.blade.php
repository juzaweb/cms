@extends('mymo_core::layouts.backend')

@section('content')
    <div class="row">
        @foreach($themes as $theme)
        <div class="col-md-4">
            <div class="card">
                <div class="height-200 d-flex flex-column kit__g13__head" style="background-image: url('{{ $theme['screenshot'] }}')">
                </div>

                <div class="card card-borderless mb-0">
                    <div class="card-header border-bottom-0">
                        <div class="d-flex">
                            <div class="text-dark text-uppercase font-weight-bold mr-auto">
                                {{ $theme['name'] }}
                            </div>
                            <div class="text-gray-6">
                                @if($theme['name'] == $activated)
                                    <button class="btn btn-secondary" disabled> Activated</button>
                                @else
                                    <button class="btn btn-primary"><i class="fa fa-check"></i> Activate</button>

                                    <a href="javascript:void(0)" class="text-danger">{{ trans('mymo_core::app.delete') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        {{ $themes->links() }}
    </div>
@endsection