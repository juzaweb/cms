@extends('cms::layouts.backend')

@section('content')

    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6 text-right">
            <a href="{{ $linkCreate }}" class="btn btn-success"><i class="fa fa-plus"></i> {{ trans('cms::app.add_new') }}</a>
        </div>
    </div>

    {{ $dataTable->render() }}

@endsection