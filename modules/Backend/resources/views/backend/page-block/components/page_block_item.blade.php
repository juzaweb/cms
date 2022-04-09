<li class="dd-item" id="dd-item-{{ $key }}" data-label="{{ $block->get('label') }}">
    <div class="dd-handle">
        <span>{{ $block->get('label') }}</span>
        <div class="dd-nodrag">
            <div class="block-action-button">
                <a href="javascript:void(0)"
                   class="show-form-block"
                >
                    <i class="fa fa-edit"></i> {{ trans('cms::app.edit') }}
                </a>

                <a href="javascript:void(0)"
                   class="remove-form-block text-danger"
                >
                    <i class="fa fa-trash"></i> {{ trans('cms::app.delete') }}
                </a>
            </div>
        </div>
    </div>

    <div class="form-block-edit dd-nodrag box-hidden" id="page-block-{{ $key }}">
        @php
        $value = $value ?? [];
        @endphp
        @component(
            'cms::backend.page-block.block_form',
            compact('data', 'key', 'contentKey', 'value')
        )
        @endcomponent

        <input type="hidden" name="blocks[{{ $contentKey }}][{{ $key }}][block]" value="{{ $block->get('key') }}">
    </div>
</li>