@php
$data = $item->getAttributes();
$register = $item->menuBox();
$menuBox = $register ? $register->get('menu_box') : false;
$view = $menuBox ? $menuBox->editView($item) : false;
@endphp
<li
    class="dd-item @if(!$register) disabled @endif"
    @foreach($data as $key => $val)
        @if(!is_array($val))
            data-{{ $key }}="{{ $val }}"
        @endif
    @endforeach
>
    <div class="dd-handle">
        <span>{{ $data['label'] }}</span>
        <a href="javascript:void(0)" class="dd-nodrag @if($register) show-menu-edit @endif">
            <i class="fa fa-sort-down"></i>
        </a>
        {{--<a href="javascript:void(0)" class="dd-nodrag text-danger delete-menu-item">
            <i class="fa fa-trash"></i>
        </a>--}}
    </div>

    <div class="form-item-edit box-hidden">
        @if(!empty($view))
            {!! $view !!}
        @endif

        <div class="form-group">
            <label class="col-form-label">{{ trans('cms::app.target') }}</label>
            <select class="form-control menu-data" data-name="target">
                <option value="_self" @if($item->target == '_self') selected @endif>{{ trans('cms::app.target_self') }}</option>
                <option value="_blank" @if($item->target == '_blank') selected @endif>{{ trans('cms::app.target_blank') }}</option>
            </select>
        </div>

        <a href="javasctipt:void(0)" class="text-danger delete-menu-item">{{ trans('cms::app.delete') }}</a>
        <a href="javasctipt:void(0)" class="text-info close-menu-item">{{ trans('cms::app.cancel') }}</a>
    </div>

    @if(!empty($children))
        <ol class="dd-list">
        @foreach($children as $child)
            {!! $builder->buildItem($child) !!}
        @endforeach
        </ol>
    @endif

</li>