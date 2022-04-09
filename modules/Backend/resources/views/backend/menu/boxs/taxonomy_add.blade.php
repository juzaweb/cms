@php
$items = app($taxonomy->get('model'))
    ->where('post_type', '=', $taxonomy->get('post_type'))
    ->where('taxonomy', '=', $taxonomy->get('taxonomy'))
    ->orderBy('id', 'desc')
    ->limit(5)
    ->get();
@endphp

<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" href="#box-{{ $key }}-latest" data-toggle="tab">{{ trans('cms::app.latest') }}</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="#box-{{ $key }}-search" id="box-{{ $key }}-search-label" data-toggle="tab">{{ trans('cms::app.search') }}</a>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane fade p-2 active show" id="box-{{ $key }}-latest" role="tabpanel" aria-labelledby="box-{{ $key }}-latest-tab">
        @foreach($items ?? [] as $item)
            <div class="form-check mt-1">
                <label class="form-check-label">
                    <input class="form-check-input select-all-{{ $key }}" type="checkbox" name="items[]" value="{{ $item->id }}">
                    {{ $item->name ?? $item->title }}
                </label>
            </div>
        @endforeach

        <div class="row mt-3">
            <div class="col-md-6">
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input select-all-checkbox" type="checkbox" data-select="select-all-{{ $key }}">
                        {{ trans('cms::app.select_all') }}
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade p-2" id="box-{{ $key }}-search" role="tabpanel" aria-labelledby="box-{{ $key }}-tab">
        <input class="form-control menu-box-taxonomy-search" type="text" placeholder="{{ trans('cms::app.search') }}" data-taxonomy="{{ $taxonomy->get('taxonomy') }}" data-key="{{ $key }}">

        <div class="box-tab-search-result mt-2">

        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input select-all-checkbox" type="checkbox" data-select="select-all-search-{{ $key }}">
                        {{ trans('cms::app.select_all') }}
                    </label>
                </div>
            </div>
        </div>

    </div>

</div>
