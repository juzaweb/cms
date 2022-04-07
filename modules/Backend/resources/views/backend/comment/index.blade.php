@extends('cms::layouts.backend')

@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="float-right">
                <div class="btn-group">

                </div>
            </div>
        </div>
    </div>

    {{ $dataTable->render() }}

@endsection