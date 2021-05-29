@extends('mymo_core::layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4>Mymo</h4>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            @lang('mymo_core::app.actived')
                        </div>

                        <div class="col-md-6 text-right">
                            <a href="{{ route('admin.design.editor') }}" data-turbolinks="false"><i class="fa fa-edit"></i> @lang('mymo_core::app.editor')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection