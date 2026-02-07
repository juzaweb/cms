@extends('core::layouts.admin')

@section('content')
    <form action="{{ $action }}" class="form-ajax" method="post">
        @if($model->exists)
            @method('PUT')
        @endif

        <div class="row">
            <div class="col-md-12">
                <a href="{{ admin_url('banner-ads') }}" class="btn btn-warning">
                    <i class="fas fa-arrow-left"></i> {{ __('ad-management::translation.back') }}
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> {{ __('ad-management::translation.save') }}
                </button>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-9">
                <x-card title="{{ __('ad-management::translation.information') }}">
                    {{ Field::text($model, 'name', ['label' => __('ad-management::translation.name')]) }}

                    {{ Field::select($model, 'type', ['label' => __('ad-management::translation.type')])->dropDownList(
                        [
                            'image' => __('ad-management::translation.image'),
                            'html' => __('ad-management::translation.html'),
                        ]
                    ) }}

                    <div id="form-banner">
                        {{ Field::uploadUrl($model, 'body_image', ['label' => __('ad-management::translation.image'), 'value' => $model->body ?? '']) }}

                        {{ Field::text($model, 'url', ['label' => __('ad-management::translation.url'), 'value' => $model->url ?? ''])
                            ->placeholder('https://')
                            ->help(__('ad-management::translation.the_url_to_open_when_the_banner_is_clicked_leave_empty_if_you_do_not_want_to_have_a_link'))
                        }}
                    </div>

                    <div id="form-editor">
                        {{ Field::textarea($model, 'body_html', ['label' => __('ad-management::translation.body'), 'rows' => 4, 'value' => $model->body ?? '']) }}
                    </div>
                </x-card>
            </div>

            <div class="col-md-3">
                <x-card title="{{ __('ad-management::translation.status') }}">
                    {{ Field::checkbox(__('ad-management::translation.active'), 'active', ['value' => $model->active ?? true]) }}
                </x-card>
                <x-card title="{{ __('ad-management::translation.position') }}">
                    {{ Field::select(__('ad-management::translation.position'), 'position', ['value' => $position ?? null])->dropDownList(
                        collect($positions)
                            ->map(fn($item) => $item->name)
                            ->prepend(__('ad-management::translation.select_position'), '')
                            ->toArray()
                    ) }}
                </x-card>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.js"
            integrity="sha512-8RnEqURPUc5aqFEN04aQEiPlSAdE0jlFS/9iGgUyNtwFnSKCXhmB6ZTNl7LnDtDWKabJIASzXrzD0K+LYexU9g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/htmlmixed/htmlmixed.min.js"
            integrity="sha512-HN6cn6mIWeFJFwRN9yetDAMSh+AK9myHF1X9GlSlKmThaat65342Yw8wL7ITuaJnPioG0SYG09gy0qd5+s777w=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.css"
          integrity="sha512-uf06llspW44/LZpHzHT6qBOIVODjWtv4MxCricRxkzvopAlSWnTf6hpZTFxuuZcuNE9CBQhqE0Seu1CoRk84nQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <script type="text/javascript" nonce="{{ csp_script_nonce() }}">
        $(function () {
            const editor = CodeMirror.fromTextArea(document.getElementById("body_html"), {
                lineNumbers: true,
                mode: "htmlmixed",
                tabSize: 2,
                lineWrapping: true,
            });

            if ($('#type').val() === 'image') {
                $('#form-editor').hide();
                $('#form-banner').show();
            } else {
                $('#form-banner').hide();
                $('#form-editor').show();
                editor.refresh();
            }

            $('#type').on('change', function () {
                if (this.value === 'image') {
                    $('#form-editor').hide();
                    $('#form-banner').show();
                    $('#form-banner input').val('');
                } else {
                    $('#form-banner').hide();
                    $('#form-editor').show();
                    editor.setValue('');
                    editor.refresh();
                }
            });
        });
    </script>
@endsection
