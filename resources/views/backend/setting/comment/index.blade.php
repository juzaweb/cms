@extends('layouts.backend')

@section('title', $title)

@section('content')

{{ Breadcrumbs::render('manager', [
        'name' => trans('app.system_setting'),
        'url' => route('admin.setting')
    ]) }}

<div class="cui__utils__content">
    <form method="post" action="{{ route('admin.setting.comment.save') }}" class="form-ajax">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-0 card-title font-weight-bold">{{ $title }}</h5>
                    </div>

                    <div class="col-md-6">
                        <div class="btn-group float-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('app.save')</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-md-12">
                        @php
                            $comment_able = \App\Models\Configs::getConfig('comment_able');
                        @endphp
                        <div class="form-group">
                            <label class="col-form-label" for="comment_able">@lang('app.comment_able')</label>
                            <select name="comment_able" id="comment_able" class="form-control">
                                <option value="1" @if($comment_able == 1) selected @endif></option>
                                <option value="0" @if($comment_able == 0) selected @endif></option>
                            </select>
                        </div>

                        @php
                        $comment_type = \App\Models\Configs::getConfig('comment_type');
                        @endphp
                        <div class="form-group">
                            <label class="col-form-label" for="comment_type">@lang('app.comment_type')</label>
                            <select name="comment_type" id="comment_type" class="form-control">
                                <option value="facebook" @if($comment_type == 'facebook') selected @endif>@lang('app.facebook_comments')</option>
                                <option value="site" @if($comment_type == 'site') selected @endif>@lang('app.site_comments_system')</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="comments_per_page">@lang('app.comments_per_page')</label>

                            <input type="number" name="comments_per_page" class="form-control" id="comments_per_page" value="{{ \App\Models\Configs::getConfig('comments_per_page') }}" autocomplete="off">
                        </div>

                        @php
                            $comments_approval = \App\Models\Configs::getConfig('comments_approval');
                        @endphp
                        <div class="form-group">
                            <label class="col-form-label" for="comments_approval">@lang('app.comments_approval')</label>

                            <select name="comments_approval" id="comments_approval" class="form-control">
                                <option value="auto" @if($comments_approval == 'auto') selected @endif>@lang('app.auto')</option>
                                <option value="manual" @if($comments_approval == 'manual') selected @endif>@lang('app.manual')</option>

                            </select>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </form>
</div>
@endsection
