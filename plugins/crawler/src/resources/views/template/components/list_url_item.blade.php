<tr id="template-page-{{ $marker }}">
    <td>
        <div class="form-group">
            <select name="pages[{{ $marker }}][page_status]" class="form-control">
                <option value="active">Enabled</option>
                <option value="inactive">Disabled</option>
            </select>
        </div>
    </td>

    <td>
        <div class="form-group">
            <input type="text" name="pages[{{ $marker }}][list_url]" class="form-control" autocomplete="off" value="{{ $item->list_url ?? '' }}">
        </div>
    </td>

    <td>
        <div class="form-group">
            <input type="text" name="pages[{{ $marker }}][list_url_page]" class="form-control" autocomplete="off" value="{{ $item->list_url_page ?? '' }}">
        </div>
    </td>

    <td>
        <div class="form-group">
            <input type="text" name="pages[{{ $marker }}][element_item]" class="form-control" autocomplete="off" value="{{ $item->element_item ?? '' }}">
        </div>
    </td>

    <td>
        <div class="form-group">
            @php
            $categories = \Juzaweb\Backend\Models\Taxonomy::whereIn('id', $item->category_ids ?? [])->get();
            @endphp
            <select name="pages[{{ $marker }}][category_ids][]" class="form-control load-taxonomies" data-taxonomy="categories" multiple>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
    </td>

    <td>
        <a href="javascript:void(0)"
           class="text-danger remove-item-page"
           data-id="{{ $item->id ?? '' }}">
            <i class="fa fa-trash"></i>
        </a>
        <input type="hidden" name="pages[{{ $marker }}][page_id]" value="{{ $item->page_id ?? '' }}">
    </td>
</tr>