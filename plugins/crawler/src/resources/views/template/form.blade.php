@extends('cms::layouts.backend')

@section('content')
    @component('cms::components.form_resource', [
        'model' => $model
    ])
        <div class="row" id="crawler-template-page">
            <div class="col-md-12">
                {{ Field::text($model, 'name', [
                    'required' => true
                ]) }}

                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6 text-right">
                        <a href="javascript:void(0)" id="add-new-page">
                            <i class="fa fa-plus"></i> {{ trans('crawler::content.add_new_page') }}
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">

                        <table class="table" id="list-page-table">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>List Url</th>
                                    <th>List Page Url</th>
                                    <th>Element Link detail</th>
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                            @foreach($model->pages as $page)
                                @component('crawler::template.components.list_url_item', [
            'marker' => 'page-' . $page->id,
            'item' => $page,
        ])
                                @endcomponent
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{ Field::select($model, 'status', [
                    'options' => [
                        'test' => 'Test',
                        'active' => 'Enabled',
                        'inactive' => 'Disabled',
                    ]
                ]) }}

                {{--<div class="form-group">
                    <label class="col-form-label" for="lang">Language</label>
                    <select name="lang" id="lang" class="form-control load-language" data-trans="1">
                        @if($model->language)
                            <option value="{{ $model->language->code }}" selected>{{ $model->language->name }}</option>
                        @endif
                    </select>
                </div>--}}

                {{ Field::selectUser($model, 'user_id', [
                    'label' => trans('cms::app.created_by')
                ]) }}

                {{ Field::select($model, 'post_status', [
                    'label' => 'Post status',
                    'options' => \Juzaweb\Backend\Models\Post::getStatuses(),
                ]) }}

                {{ Field::checkbox($model, 'auto_leech', [
                    'label' => 'Auto leech',
                    'value' => 1,
                    'checked' => $model->auto_leech == 1,
                ]) }}

                <hr>
                <button type="button" class="btn btn-success btn-sm" id="show-preview-list"><i class="fa fa-eye"></i> Preview</button>
                <button type="button" class="btn btn-warning btn-sm" id="clear-preview-list"><i class="fa fa-times"></i> Clear</button>

                <div id="list-preview" class="box-hidden">
                    <ul class="list-group" id="preview-list"></ul>
                </div>
            </div>
        </div>

        <input type="hidden" name="id" value="{{ $model->id }}">
    @endcomponent

    <input type="hidden" id="preview-link" value="{{ $linkPreview }}">

    <template id="list-url-template">
        @component('crawler::template.components.list_url_item', [
            'marker' => '{marker}',
        ])
        @endcomponent
    </template>
@endsection
