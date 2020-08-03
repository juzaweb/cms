<div class="modal fade" id="tmdb-modal" tabindex="-1" role="dialog" aria-labelledby="tmdbModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('admin.tmdb.add_movie') }}" method="post" class="form-ajax">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tmdbModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="@lang('app.close')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label class="col-form-label" for="tmdb">TMDB ID</label>
                        <input type="text" name="tmdb" class="form-control" id="tmdb" autocomplete="off" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus-circle"></i> @lang('app.add_movie')</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close"></i> @lang('app.close')</button>
                </div>
            </div>
        </form>
    </div>
</div>

