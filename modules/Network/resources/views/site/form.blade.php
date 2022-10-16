@extends('network::layout')

@section('content')

    @component('cms::components.form_resource', [
        'model' => $model
    ])
        <input type="hidden" name="id" value="{{ $model->id }}">

        <div class="row">
            <div class="col-md-8">
                {{ Field::text($model, 'domain') }}

                @if($model->id)
                    <div class="row mb-2">
                        <div class="col-md-6"></div>
                        <div class="col-md-6 text-right">
                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#add-domain-modal">
                                <i class="fa fa-plus"></i> {{ __('Add domain') }}
                            </button>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ trans('cms::app.domain') }}</th>
                            <th class="w-25 text-center">{{ trans('cms::app.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mappingMomains as $index => $mappingMomain)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $mappingMomain->domain }}</td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" class="text-danger"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <div class="col-md-4">
                {{ Field::select($model, 'status', [
                    'options' => $statuses
                ]) }}
            </div>
        </div>
    @endcomponent

    @if($model->id)
        <div class="modal fade" id="add-domain-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="post" action="{{ route('network.sites.add-mapping-domain', [$model->id]) }}" class="form-ajax">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ __('Add Mapping domain') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{ Field::text(__('Domain'), 'domain') }}

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

@endsection
