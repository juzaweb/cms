@extends('cms::layouts.backend')

@section('content')
    @component('cms::components.form_resource', [
            'action' => $model->id ? route('admin.email-template.update', [$model->id]) : route('admin.email-template.store'),
            'method' => $model->id ? 'put' : 'post'
        ])

        <input type="hidden" name="id" value="{{ $model->id }}">

        <div class="row">
            <div class="col-md-8">
                @component('cms::components.form_input', [
                    'label' => trans('cms::app.code'),
                    'name' => 'code',
                    'value' => $model->code,
                    'required' => true
                ])
                @endcomponent

                @component('cms::components.form_input', [
                    'label' => trans('cms::app.subject'),
                    'name' => 'subject',
                    'value' => $model->subject,
                    'required' => true
                ])
                @endcomponent

                @component('cms::components.form_textarea', [
                    'label' => trans('cms::app.body'),
                    'name' => 'body',
                    'value' => $model->body
                ])
                @endcomponent
            </div>

            <div class="col-md-4">
                @component('cms::components.form_select', [
                    'label' => trans('cms::app.email_hook'),
                    'name' => 'email_hook',
                    'value' => $model->email_hook,
                    'options' => array_merge([
                        '' => trans('cms::app.select', ['name' => trans('cms::app.email_hook')])
                    ], jw_get_select_options($emailHooks))
                ])
                @endcomponent
            </div>
        </div>

        <script type="text/javascript">
            var mixedMode = {
                name: "htmlmixed",
                scriptTypes: [{matches: /\/x-handlebars-template|\/x-mustache/i,
                    mode: null},
                    {matches: /(text|application)\/(x-)?vb(a|script)/i,
                        mode: "vbscript"}]
            };

            var editor = CodeMirror.fromTextArea(document.getElementById("body"), {
                mode: mixedMode,
                lineNumbers: true,
                styleActiveLine: true,
                matchBrackets: true,
                lineWrapping: true,
                extraKeys: {"Ctrl-Space": "autocomplete"},
            });

            editor.setOption("theme", 'default');
        </script>
    @endcomponent
@endsection