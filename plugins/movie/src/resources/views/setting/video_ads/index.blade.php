@extends('cms::layouts.backend')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="float-right">

                <div class="btn-group">
                    <a href="{{ $linkCreate }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> @lang('cms::app.add_new')</a>
                </div>
            </div>
        </div>
    </div>

    {{ $dataTable->render() }}

@endsection