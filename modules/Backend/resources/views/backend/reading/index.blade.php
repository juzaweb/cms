@extends('cms::layouts.backend')

@section('content')
    <div class="row mt-3">
        <div class="col-md-12">

            @component('cms::components.form', [
                'method' => 'post',
                'action' => route('admin.reading.save')
            ])

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">{{ trans('cms::app.your_homepage_displays') }}</label>
                    <div class="col-md-6">
                        <div class="form-check mb-2">
                            <label class="form-check-label">
                                <input type="radio" name="show_on_front" value="posts" class="show_on_front-change" {{ get_config('show_on_front', 'posts') == 'posts' ? 'checked' : '' }}> {{ trans('cms::app.your_latest_posts') }}
                            </label>
                        </div>

                        <div class="form-check mb-2">
                            <label class="form-check-label">
                                <input type="radio" name="show_on_front" value="page" class="show_on_front-change" {{ get_config('show_on_front', 'posts') == 'page' ? 'checked' : '' }}> {{ trans('cms::app.a_static_page') }}
                            </label>
                        </div>

                        <div class="mb-2">
                            <select name="home_page" class="form-control select-show_on_front load-pages" data-placeholder="--- {{ trans('cms::app.select', ['name' => trans('cms::app.page')]) }} ---" {{ get_config('show_on_front', 'posts') == 'posts' ? 'disabled' : '' }}>
                                @if($page = jw_get_page(get_config('home_page')))
                                    <option value="{{ $page->id }}">{{ $page->title }}</option>
                                @endif
                            </select>
                        </div>

                        <div class="mb-2">
                            <select name="post_page" class="form-control select-show_on_front load-pages" data-placeholder="--- {{ trans('cms::app.select', ['name' => trans('cms::app.page')]) }} ---" {{ get_config('show_on_front', 'posts') == 'posts' ? 'disabled' : '' }}>
                                @if($page = jw_get_page(get_config('post_page')))
                                    <option value="{{ $page->id }}">{{ $page->title }}</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">
                        {{ trans('Blog pages show at most') }}
                    </label>

                    <div class="col-md-4">
                        <input type="number" class="form-control" name="posts_per_page" value="{{ get_config('posts_per_page', 12) }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">
                        {{ trans('Syndication feeds show the most recent') }}
                    </label>

                    <div class="col-md-4">
                        <input type="number" class="form-control" name="posts_per_rss" value="{{ get_config('posts_per_rss', 10) }}">
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> {{ trans('cms::app.save') }}
                    </button>
                </div>

            @endcomponent

        </div>
    </div>
@endsection
