@extends('mymo::layouts.backend')

@section('content')
    <ul class="nav nav-tabs nav-tabs-line">
        @foreach($forms as $key => $form)
            <li class="nav-item">
                <a class="nav-link @if($key == $component) active @endif" href="{{ route('admin.setting.form', [$key]) }}">{{ $form['name'] ?? '' }}</a>
            </li>
        @endforeach
    </ul>

    <div class="tab-content">
        <div class="tab-pane p-2 active" role="tabpanel" aria-labelledby="home-tab">
            @if(view()->exists($forms[$component]['view']))
                @include($forms[$component]['view'])
            @endif
        </div>
    </div>
@endsection
