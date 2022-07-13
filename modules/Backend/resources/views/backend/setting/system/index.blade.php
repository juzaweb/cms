@extends('cms::layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                @foreach($forms as $key => $form)
                <a class="list-group-item @if($key == $component) active @endif" href="{{ route('admin.setting.form', [$key]) }}">{{ $form->get('name') }}</a>
                @endforeach
            </div>
        </div>

        <div class="col-md-9">
            <form action="{{ route('admin.setting.save') }}" method="post" class="form-ajax">
                <input type="hidden" name="form" value="general">

                <div class="card">
                    @if($forms[$component]['header'] ?? true)
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <div class="btn-group float-right">
                                    <button type="submit" class="btn btn-success"> Save </button>
                                    <button type="reset" class="btn btn-default"> Reset </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="card-body">
                        @if(is_string($forms[$component]['view']))
                            @if(view()->exists($forms[$component]['view']))
                                @include($forms[$component]['view'])
                            @endif
                        @else
                            {{ $forms[$component]['view'] }}
                        @endif
                    </div>

                    @if($forms[$component]['footer'] ?? true)
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6"></div>

                            <div class="col-md-6">
                                <div class="btn-group float-right">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-save"></i> {{ trans('cms::app.save') }}
                                    </button>

                                    <button type="reset" class="btn btn-default">
                                        <i class="fa fa-refresh"></i> {{ trans('cms::app.reset') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
