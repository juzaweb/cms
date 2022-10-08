@extends('cms::layouts.backend')

@section('content')

    <form method="post" action="{{ route('admin.setting.email_templates.edit_layout.save') }}" class="form-ajax">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-0 card-title font-weight-bold">{{ $model->title }}</h5>
                    </div>

                    <div class="col-md-6">
                        <div class="btn-group float-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> {{ trans('cms::app.save') }}</button>
                            <a href="{{ route('admin.setting.email_templates') }}" class="btn btn-warning"><i class="fa fa-times-circle"></i> {{ trans('cms::app.cancel') }}</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-md-12">

                        <div class="form-group">
                            <label class="col-form-label" for="content">{{ trans('cms::app.content') }}</label>
                            <textarea class="form-control" name="content" id="content" rows="6">{{ $model->code }}</textarea>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </form>

    <script type="text/javascript">
        var editor = CodeMirror.fromTextArea(document.getElementById("content"), {
            lineNumbers: true,
            extraKeys: {"Ctrl-Space": "autocomplete"},
            mode: "text/html",
        });
    </script>
@endsection
