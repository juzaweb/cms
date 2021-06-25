<form method="post" action="{{ route('admin.setting.save.block_ip') }}" class="form-ajax">
    <input type="hidden" name="form" value="player">
    @php
        $block_ip_status = get_config('block_ip_status');
        $block_ip_type = get_config('block_ip_type');
        $block_ip_list = get_config('block_ip_list');
    @endphp
    <div class="form-group">
        <label class="col-form-label" for="block_ip_status">@lang('mymo::app.block_ip_status')</label>
        <select name="block_ip_status" id="block_ip_status" class="form-control">
            <option value="1" @if($block_ip_status == 1) selected @endif>@lang('mymo::app.enabled')</option>
            <option value="0" @if($block_ip_status == 0) selected @endif>@lang('mymo::app.disabled')</option>
        </select>
    </div>

    <div class="form-group">
        <label class="col-form-label" for="block_ip_status">@lang('mymo::app.block_ip_type')</label>
        <select name="block_ip_status" id="block_ip_status" class="form-control">
            <option value="1" @if($block_ip_type == 1) selected @endif>@lang('mymo::app.enabled')</option>
            <option value="0" @if($block_ip_type == 2) selected @endif>@lang('mymo::app.disabled')</option>
        </select>
    </div>

    <div class="form-group">
        <label class="col-form-label" for="block_ip_status">@lang('mymo::app.block_ip_list')</label>
        <select name="block_ip_list[]" id="block_ip_list" class="form-control load-countries-g" data-placeholder="--- @lang('mymo::app.block_ip_list') ---"></select>
    </div>

    <div class="row">
        <div class="col-md-6"></div>

        <div class="col-md-6">
            <div class="btn-group float-right">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-save"></i> @lang('mymo::app.save')
                </button>

                <button type="reset" class="btn btn-default">
                    <i class="fa fa-refresh"></i> @lang('mymo::app.reset')
                </button>
            </div>
        </div>
    </div>
</form>