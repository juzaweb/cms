@extends('layouts.backend')

@section('title', $title)

@section('content')

{{ Breadcrumbs::render('manager', [
        'name' => trans('app.system_setting'),
        'url' => route('admin.setting')
    ]) }}

<div class="cui__utils__content">
    <form method="post" action="{{ route('admin.setting.save') }}" class="form-ajax">
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
                    <div class="col-md-8">

                        <div class="form-group">
                            <label class="col-form-label" for="title">@lang('app.name')</label>

                            <input type="text" name="title" class="form-control" id="title" value="" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="description">@lang('app.description')</label>
                            <textarea class="form-control" name="description" id="description" rows="5"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="title">@lang('app.logo')</label>


                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="title">@lang('app.icon')</label>


                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="title">@lang('app.banner')</label>


                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-form-label" for="title">@lang('app.register')</label>

                            <select name="" id="" class="form-control">
                                <option value="1">@lang('app.enabled')</option>
                                <option value="0">@lang('app.disabled')</option>
                            </select>
                        </div>


                    </div>
                </div>


            </div>
        </div>
    </form>
</div>
@endsection
