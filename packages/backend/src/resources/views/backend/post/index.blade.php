@extends('cms::layouts.backend')

@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="btn-group float-right">
                @if($canCreate)
                <a href="{{ $linkCreate }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> {{ trans('cms::app.add_new') }}</a>
                @endif

                @do_action("post_type.{$setting->get('key')}.btn_group")
            </div>
        </div>
    </div>

    {{ $dataTable->render() }}

    @do_action("post_type.{$setting->get('key')}.index")

@endsection