@extends('cms::layouts.backend')

@section('header')
    <link rel="stylesheet" href="{{ asset('jw-styles/juzaweb/css/code-editor.min.css') }}" />
    <script>
        const loadFileUrl = "";
        const saveUrl = "";
        const monacoFolder = "{{ asset('jw-styles/juzaweb/monaco-editor/min/vs') }}";
        let file = "{{ $file }}";
    </script>
    <script src="{{ asset('jw-styles/juzaweb/js/code-editor.min.js') }}"></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div id="editor"></div>
        </div>

        <div class="col-md-3">
            <select id="change-theme" class="form-control">
                <option value=""></option>
            </select>

            <div class="treeview-animated mt-2 w-20 border">
                <h6 class="pt-3 pl-3">{{ trans('cms::app.folders') }}</h6>
                <hr>
                <ul class="treeview-animated-list mb-3">
                    @foreach($directories as $directory)
                        @component('cms::backend.appearance.editor.components.tree_item', [
                            'item' => $directory,
                        ])
                        @endcomponent
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="row mt-3 mb-3">
        <div class="col-md-6">
            <div class="btn-group">
                <button type="submit" class="btn btn-success px-5">
                    <i class="fa fa-save"></i> {{ trans('cms::app.save_change') }}
                </button>
            </div>
        </div>
    </div>
@endsection
