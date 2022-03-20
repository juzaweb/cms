<tr>
    <td>
        <select name="mlla_subdomain[{{ $marker }}][language]" class="form-control">
            <option value="">-------</option>
            @foreach($languages as $language)
                <option value="{{ $language->code }}" @if(($item['language'] ?? '') == $language->code) selected @endif>
                    {{ $language->name }}
                </option>
            @endforeach
        </select>
    </td>
    <td>
        <div class="col-auto">
            <label class="sr-only" for="sub-{{ $marker }}">Subdomain</label>
            <div class="input-group mb-2">
                <input type="text" class="form-control" name="mlla_subdomain[{{ $marker }}][sub]" id="sub-{{ $marker }}" value="{{ $item['sub'] ?? '' }}">
                <div class="input-group-prepend">
                    <div class="input-group-text">.{{ request()->getHost() }}</div>
                </div>
            </div>
        </div>
    </td>
</tr>