@extends('mymo_core::layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <ul class="list-group" id="setting-menu">
                @foreach($settings as $key => $setting)
                    <a href="{{ route('admin.setting.form', [$key]) }}" class="list-group-item @if($key == $form) active @endif" data-form="general">{{ $setting }}</a>
                @endforeach
            </ul>
        </div>

        <div class="col-md-9">

            <div class="card">

                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-0 card-title font-weight-bold">{{ @$settings[$form] }}</h5>
                        </div>
                    </div>
                </div>

                <div class="card-body" id="setting-form">
                    {!! $form_content !!}
                </div>

            </div>
        </div>
    </div>
@endsection
