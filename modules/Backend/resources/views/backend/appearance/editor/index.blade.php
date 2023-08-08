@extends('cms::layouts.backend')

@section('header')
    <link rel="stylesheet" href="{{ asset('jw-styles/juzaweb/css/code-editor.min.css') }}" />
    <script>
        const currentTheme = "{{ $theme }}";
        const themeEditUrl = "{{ route('admin.theme.editor', ['__THEME__']) }}";
        const loadFileUrl = "{{ route('admin.theme.editor.content', [$theme]) }}";
        const saveUrl = "{{ route('admin.theme.editor.save', [$theme]) }}";
        const monacoFolder = "{{ asset('jw-styles/juzaweb/monaco-editor/min/vs') }}";
        let file = "{{ $file }}";
    </script>
    <script src="{{ asset('jw-styles/juzaweb/js/theme-editor.min.js') }}"></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div id="editor"></div>
        </div>

        <div class="col-md-3">
            <button type="button" class="btn btn-success" id="save-change">
                <i class="fa fa-save"></i> {{ trans('cms::app.save_change') }}
            </button>

            <select id="change-theme" class="form-control mt-2">
                @foreach($themes as $name => $info)
                    <option value="{{ $name }}" @if($name == $theme) selected @endif>
                        {{ $info->get('title') }}
                    </option>
                @endforeach
            </select>

            <div class="treeview-animated mt-2 w-20 border">
                <h6 class="pt-3 pl-3">{{ trans('cms::app.folders') }}</h6>
                <hr>
                <ul class="treeview-animated-list mb-3">
                    @foreach($directories as $directory)
                        @component('cms::backend.appearance.editor.components.tree_item', [
                            'item' => $directory,
                            'theme' => $theme
                        ])
                        @endcomponent
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
