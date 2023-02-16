@extends('cms::layouts.backend')

@section('content')
    @if($setting->get('create_button', true))
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="btn-group float-right">
                <a href="{{ $linkCreate }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> {{ trans('cms::app.add_new') }}</a>
            </div>
        </div>
    </div>
    @endif

    {{ $dataTable->render() }}
@endsection
