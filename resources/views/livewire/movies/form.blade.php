@section('title', $title_page)

<div>
    {{ Breadcrumbs::render('manager', [
            'name' => trans('app.movies'),
            'url' => route('admin.movies')
        ], $this) }}

    <div class="cui__utils__content">
        <form wire:submit.prevent="save">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-0 card-title font-weight-bold">{{ $title_page }}</h5>
                        </div>

                        <div class="col-md-6">
                            <div class="btn-group float-right">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('app.save')</button>
                                <a href="{{ route('admin.movies') }}" class="btn btn-warning"><i class="fa fa-times-circle"></i> @lang('app.cancel')</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="col-form-label" for="baseName">@lang('app.name')</label>

                                <input type="text" wire:model="name" class="form-control" id="baseName" value="" autocomplete="off"/>
                                @error('name') <span class="error">{{ $message }}</span> @enderror

                            </div>

                            <div class="form-group">
                                <label class="col-form-label" for="baseDescription">@lang('app.description')</label>
                                <textarea class="form-control" wire:model="description" id="baseDescription" rows="6"></textarea>
                                @error('description') <span class="error">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label class="col-form-label" for="baseStatus">@lang('app.status')</label>
                                <select wire:model="status" id="baseStatus" class="form-control">
                                    <option value="1">@lang('app.enabled')</option>
                                    <option value="0">@lang('app.disabled')</option>
                                </select>
                                @error('status') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-thumbnail text-center">
                                <input id="thumbnail" type="hidden" wire:model="thumbnail">
                                <img src="{{ asset('imgs/default.png') }}" id="holder" class="w-100">

                                <a href="javascript:void(0)" id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-capitalize">
                                    <i class="fa fa-picture-o"></i> @lang('app.choose_image')
                                </a>

                                @error('thumbnail') <span class="error">{{ $message }}</span> @enderror
                            </div>

                        </div>
                    </div>

                    <input type="hidden" wire:model="mid">
                </div>
            </div>
        </form>
    </div>
</div>
