@extends('cms::layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-12">

            <p class="mb-4">{{ trans('cms::app.permalink_description', ['url' => url('/')]) }}</p>

            @component('cms::components.form', [
                'method' => 'post',
                'action' => route('admin.permalink.save')
            ])

                @foreach($permalinks as $key => $permalink)
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="{{ $key }}-base">{{ $permalink->get('label') }} {{ trans('cms::app.base') }}</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ url('/') }}/</span>
                            </div>
                            <input type="text" name="permalink[{{ $key }}][base]" class="form-control" id="{{ $key }}-base" value="{{ $permalink->get('base') }}">
                            <div class="input-group-prepend">
                                <span class="input-group-text">/{slug}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="mt-3">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> {{ trans('cms::app.save') }}
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="fa fa-refresh"></i> {{ trans('cms::app.reset') }}
                    </button>
                </div>

            @endcomponent

        </div>
    </div>
@endsection
