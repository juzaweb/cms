<div class="form-group form-taxonomy">
    <label class="col-form-label w-100">
        {{ $setting->get('label') }}
        <span><a href="javascript:void(0)" class="float-right"><i class="fa fa-plus"></i> @lang('tadcms::app.add-new')</a></span>
    </label>

    <div class="show-taxonomies taxonomy-{{ $taxonomy }}">
        <ul class="mt-2 p-0">
            {{--@foreach($items as $item)
                <li class="m-1" id="item-category-{{ $item->id }}">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="taxonomies[]" class="custom-control-input" id="{{ $taxonomy }}-{{ $item->id }}" value="{{ $item->id }}" @if(in_array($item->id, $value ?? [])) checked @endif>
                        <label class="custom-control-label" for="{{ $taxonomy }}-{{ $item->id }}">{{ $item->name }}</label>
                    </div>
                </li>
            @endforeach--}}
        </ul>
    </div>

    <div class="form-add">
        <div class="form-group">
            <label class="col-form-label">{{ trans('tadcms::app.name') }} <abbr>*</abbr></label>
            <input type="text" class="form-control" autocomplete="off">
        </div>

        <div class="form-group">
            <label class="col-form-label">{{ trans('tadcms::app.parent') }}</label>
            <select type="text" class="form-control load-taxonomy" data-type="{{ $setting->get('type') }}" data-taxonomy="{{ $taxonomy }}">
            </select>
        </div>

        <button type="button" class="btn btn-primary"><i class="fa fa-plus-circle"></i> {{ trans('tadcms::app.add') }}</button>
    </div>
</div>
