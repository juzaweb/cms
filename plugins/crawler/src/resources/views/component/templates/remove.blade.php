<tr>
    <td><input type="text" name="removes[{{ $marker }}][element]" class="form-control" value="{{ $item->element ?? '' }}"></td>
    <td><input type="text" name="removes[{{ $marker }}][index]" class="form-control" value="{{ $item->index ?? '' }}"></td>
    <td>
        @php
        $removeType = $item->type ?? '';
        @endphp
        <select name="removes[{{ $marker }}][type]" class="form-control">
            <option value="1" @if($removeType == 1) selected @endif>Remove all</option>
            <option value="2" @if($removeType == 2) selected @endif>Remove html</option>
        </select>
    </td>
    <td>
        <input type="hidden" name="removes[{{ $marker }}][remove_id]" value="{{ $item->id ?? '' }}">
        <a href="javascript:void(0)"
           class="remove-item-remove text-danger"
           data-id="{{ $item->id ?? '' }}">
            <i class="fa fa-trash"></i>
        </a>
    </td>
</tr>