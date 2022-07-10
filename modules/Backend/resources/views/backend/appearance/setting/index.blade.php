@extends('cms::layouts.backend')

@section('content')
    <form action="" method="post" class="form-ajax">
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6 text-right">
                <div class="btn-group">
                    <button type="submit" class="btn btn-success px-5">
                        <i class="fa fa-save"></i> {{ trans('cms::app.save') }}
                    </button>

                    <button type="button" class="btn btn-warning cancel-button px-3">
                        <i class="fa fa-refresh"></i> {{ trans('cms::app.reset') }}
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                @foreach($configs as $config)
                    @php
                        $config['data']['value'] = get_theme_config($config['name']);
                        $config['name'] = "theme[{$config['name']}]";
                    @endphp

                    {{ Field::fieldByType($config) }}
                @endforeach
            </div>

            <div class="col-md-4">
                {{ Field::image(trans('cms::app.logo'), 'config[logo]', [
                    'value' => get_config('logo')
                ]) }}

                {{ Field::image(trans('cms::app.icon'), 'config[icon]', [
                    'value' => get_config('icon')
                ]) }}
            </div>
        </div>
    </form>
@endsection
