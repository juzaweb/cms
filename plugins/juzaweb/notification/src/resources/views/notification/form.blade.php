@extends('cms::layouts.backend')

@section('content')
    @component('cms::components.form_resource', [
        'model' => $model
    ])
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label class="col-form-label" for="users">@lang('cms::app.send_for') <abbr>*</abbr></label>
                    <select name="users[]" id="users" class="form-control load-users" data-placeholder="--- @lang('cms::app.users') ---" multiple @if($model->users == -1) disabled @endif>
                        @if(!empty($users))
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                            @endforeach
                        @endif
                    </select>

                    <input type="checkbox" class="all-users" id="all-users" @if($model->users == -1) checked @endif> <label for="all-users">@lang('cms::app.all_users')</label>
                </div>

                @component('cms::components.form_input', [
                    'label' => trans('cms::app.subject'),
                    'name' => 'data[subject]',
                    'value' => $model->data['subject'] ?? '',
                    'required' => true
                ])
                @endcomponent

                {{ Field::editor(trans('cms::app.content'), 'data[body]', [
                    'value' => $model->data['body'] ?? ''
                ]) }}

            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-form-label">@lang('cms::app.via') <abbr>*</abbr></label>
                    @php
                    $methods = $model->method ? explode(',', $model->method) : [];
                    @endphp
                    @foreach($vias as $key => $via)
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="method-{{ $key }}" name="via[{{ $key }}]" value="{{ $key }}" @if(in_array($key, $methods)) checked @endif>
                            <label class="custom-control-label text-capitalize" for="method-{{ $key }}">{{ $key }}</label>
                        </div>
                    @endforeach
                </div>

                @component('cms::components.form_image', [
                    'label' => trans('cms::app.image'),
                    'name' => 'data[image]',
                    'value' => $model->data['image']  ?? '',
                ])
                @endcomponent

                @component('cms::components.form_input', [
                    'label' => trans('cms::app.url'),
                    'name' => 'data[url]',
                    'value' => $model->data['url'] ?? '',
                ])
                @endcomponent
            </div>

        </div>
    @endcomponent

    <script type="text/javascript">
        $('.all-users').on('change', function () {
            if ($(this).is(':checked')) {
                $('#users').prop('disabled', true);
            } else {
                $('#users').prop('disabled', false);
            }
        });
    </script>
@endsection
