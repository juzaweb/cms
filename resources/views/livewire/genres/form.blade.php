@section('title', $title_page)

<div>

    <div class="cui__breadcrumbs">
        <div class="cui__breadcrumbs__path">
            <a href="{{ route('admin.dashboard') }}">@lang('app.home')</a>

            <span>
                <span class="cui__breadcrumbs__arrow"></span>
                <a href="{{ route('admin.genres') }}">@lang('app.genres')</a>
            </span>
            <span>
                <span class="cui__breadcrumbs__arrow"></span>
                <strong class="cui__breadcrumbs__current">{{ $title_page }}</strong>
            </span>
        </div>
    </div>

    <div class="cui__utils__content">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-4">
                    <strong>{{ $title_page }}</strong>
                </h4>

                <form wire:submit.prevent="save">
                    <input type="hidden" wire:model="mid" value="">
                    
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="baseName">@lang('app.name')</label>
                        <div class="col-md-6">
                            <input type="text" wire:model="name" class="form-control" id="baseName" value=""/>
                            @error('name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="baseDescription">@lang('app.description')</label>
                        <div class="col-md-6">
                            <textarea class="form-control" wire:model="description" id="baseDescription" rows="4"></textarea>
                            @error('description') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="baseStatus">@lang('app.status')</label>
                        <div class="col-md-6 pt-2">
                            <select wire:model="status" id="baseStatus" class="form-control">
                                <option value="1">@lang('app.enabled')</option>
                                <option value="0">@lang('app.disabled')</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success px-5">@lang('app.save')</button>
                </form>
            </div>
        </div>
    </div>

</div>
