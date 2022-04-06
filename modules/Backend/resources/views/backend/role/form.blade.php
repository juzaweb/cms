@extends('cms::layouts.backend')

@section('content')
    @component('cms::components.form_resource', [
        'model' => $model
    ])

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">{{ trans('cms::app.general') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="permission-tab" data-toggle="tab" href="#permission" role="tab" aria-controls="permission" aria-selected="false">{{ trans('cms::app.permissions') }}</a>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane p-3 fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                @include('cms::backend.role.components.general')
            </div>
            <div class="tab-pane p-3 fade" id="permission" role="tabpanel" aria-labelledby="permission-tab">
                @include('cms::backend.role.components.permission')
            </div>
        </div>
    @endcomponent

    <script type="text/javascript">
        $('body').on('change', '.check-all-permissions', function () {
            let checked = $(this).is(':checked');
            $(this).closest('.row')
                .find('.perm-check-item')
                .prop('checked', checked);
        });
    </script>
@endsection
