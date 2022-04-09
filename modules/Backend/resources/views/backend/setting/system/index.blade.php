@extends('cms::layouts.backend')

@section('content')
    <ul class="nav nav-tabs">
        @foreach($forms as $key => $form)
            <li class="nav-item">
                <a class="nav-link @if($key == $component) active @endif" href="{{ route('admin.setting.form', [$key]) }}">{{ $form->get('name') }}</a>
            </li>
        @endforeach
    </ul>
    <div class="tab-content">
        <div class="tab-pane p-2 active" role="tabpanel" aria-labelledby="home-tab">
            @if(is_string($forms[$component]['view']))
                @if(view()->exists($forms[$component]['view']))
                    @include($forms[$component]['view'])
                @endif
            @else
                {{ $forms[$component]['view'] }}
            @endif

        </div>
    </div>
@endsection
