@extends('mymo::layouts.backend')

@section('content')
    @component('mymo::components.form_resource', [
        'action' => $model->id ? route('admin.notification.update', [$model->id]) :
                    route('admin.notification.store'),
        'method' => $model->id ? 'put' : 'post'
    ])
        <div class="row">
            <div class="col-md-8">
                <input type="hidden" name="redirect" value="{{ route('admin.notification.index') }}">

                <div class="form-group">
                    <label class="col-form-label" for="users">@lang('mymo::app.send_for') <abbr>*</abbr></label>
                    <select name="users[]" id="users" class="form-control load-users" data-placeholder="--- @lang('mymo::app.users') ---" multiple @if($model->users == -1) disabled @endif>
                        @if(!empty($users))
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                            @endforeach
                        @endif
                    </select>

                    <input type="checkbox" class="all-users" @if($model->users == -1) checked @endif> @lang('mymo::app.all_users')
                </div>

                @component('mymo::components.form_input', [
                    'label' => trans('mymo::app.subject'),
                    'name' => 'data[subject]',
                    'value' => $model->data['subject'] ?? '',
                    'required' => true
                ])
                @endcomponent

                @component('mymo::components.form_ckeditor', [
                    'label' => trans('mymo::app.content'),
                    'name' => 'data[content]',
                    'value' => $model->data['content'] ?? '',
                ])
                @endcomponent
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-form-label">@lang('mymo::app.via') <abbr>*</abbr></label>
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

                @component('mymo::components.form_image', [
                    'label' => trans('mymo::app.image'),
                    'name' => 'data[image]',
                    'value' => $model->data['image']  ?? '',
                ])
                @endcomponent

                @component('mymo::components.form_input', [
                    'label' => trans('mymo::app.url'),
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
