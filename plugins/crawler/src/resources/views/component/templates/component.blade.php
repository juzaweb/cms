<tr>
    <td><input type="text" name="components[{{ $marker }}][code]" class="form-control" value="{{ $item->code ?? '' }}"></td>
    <td><input type="text" name="components[{{ $marker }}][element]" class="form-control" value="{{ $item->element ?? '' }}"></td>
    <td><input type="text" name="components[{{ $marker }}][attr]" class="form-control" value="{{ $item->attr ?? '' }}"></td>
    <td><input type="text" name="components[{{ $marker }}][index]" class="form-control" value="{{ $item->index ?? '' }}"></td>
    <td>
        <input type="hidden" name="components[{{ $marker }}][component_id]" value="{{ $item->id ?? '' }}">
        <a href="javascript:void(0)" class="remove-item-component text-danger" data-id="{{ $item->id ?? '' }}"><i class="fa fa-trash"></i></a>
    </td>
</tr>