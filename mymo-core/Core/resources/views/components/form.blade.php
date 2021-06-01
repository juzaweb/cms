<form action="{{ $action ?? '' }}" method="post" class="form-ajax">
    @if(isset($method) && $method == 'put')
        @method('PUT')
    @endif

    <div class="row mb-2">
        <div class="col-md-6"></div>

        <div class="col-md-6">
            <div class="btn-group float-right">
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('tadcms::app.save')</button>

                <button type="reset" class="btn btn-warning"><i class="fa fa-refresh"></i> @lang('tadcms::app.reset')</button>
            </div>
        </div>
    </div>

    {{ $slot ?? '' }}

    <div class="row mt-3">
        <div class="col-md-12">
            <div class="btn-group">
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('tadcms::app.save')</button>
                <button type="reset" class="btn btn-warning"><i class="fa fa-refresh"></i> @lang('tadcms::app.reset')</button>
            </div>
        </div>
    </div>

</form>