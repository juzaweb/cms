@extends('cms::layouts.backend')

@section('content')
    
<div class="container-fluid">
    <form method="post" action="{{ route('backend.leech.template.save') }}" class="form-ajax" id="form">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-0 card-title font-weight-bold">{{ $title ?? '' }}</h5>
                    </div>

                    <div class="col-md-6">
                        <div class="btn-group float-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                            <a href="{{ route('backend.leech.template') }}" class="btn btn-warning"><i class="fa fa-times-circle"></i> Cancel</a>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-md-8">

                        @include('backend.leech.template.form.list')

                        @include('backend.leech.template.form.component')

                        @include('backend.leech.template.form.remove')

                        @include('backend.leech.template.form.leech')

                    </div>

                    <div class="col-md-4">

                        <div class="form-group">
                            <label class="col-form-label" for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="2" @if($model->status == 2) selected @endif>Test</option>
                                <option value="1" @if($model->status == 1) selected @endif>Enabled</option>
                                <option value="0" @if($model->status == 0 && !is_null($model->status)) selected @endif>Disabled</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="auto_leech">Auto leech</label>
                            <select name="auto_leech" id="auto_leech" class="form-control">
                                <option value="1" @if($model->auto_leech == 1) selected @endif>Enabled</option>
                                <option value="0" @if($model->auto_leech == 0 && !is_null($model->auto_leech)) selected @endif>Disabled</option>
                            </select>
                        </div>

                    </div>
                </div>

                <input type="hidden" name="id" value="{{ $model->id }}">
            </div>
        </div>
    </form>

    <template id="component-template">
        <tr>
            <td><input type="text" name="component_code[]" class="form-control" value=""></td>
            <td><input type="text" name="component_element[]" class="form-control" value=""></td>
            <td><input type="text" name="component_attr[]" class="form-control" value=""></td>
            <td><input type="text" name="component_index[]" class="form-control" value=""></td>
            <td><input type="checkbox" class="form-control component-trans" checked><input type="hidden" name="component_trans[]" value="1"></td>
            <td>
                <input type="hidden" name="component_id" value="">
                <a href="javascript:void(0)" class="remove-component" data-id="">Remove</a>
            </td>
        </tr>
    </template>

    <template id="remove-template">
        <tr>
            <td><input type="text" name="remove_element[]" class="form-control" value=""></td>
            <td><input type="text" name="remove_index[]" class="form-control" value=""></td>
            <td>
                <input type="hidden" name="remove_id" value="">
                <a href="javascript:void(0)" class="remove-remove" data-id="">Remove</a>
            </td>
        </tr>
    </template>
</div>
@endsection
