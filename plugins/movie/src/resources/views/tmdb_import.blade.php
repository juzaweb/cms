<div class="modal fade" id="tmdb-modal" tabindex="-1" role="dialog" aria-labelledby="tmdbModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('admin.ajax', ['tmdb-add_movie']) }}" method="post" class="form-ajax">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tmdbModalLabel">Add from TMDB</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label" for="tmdb">TMDB ID</label>
                        <input type="text" name="tmdb" class="form-control" id="tmdb" autocomplete="off" required>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="type">Type</label>
                        <select name="type" class="form-control" id="type">
                            <option value="1">Movie</option>
                            <option value="2">TV Series</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add movie</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                </div>
            </div>
        </form>
    </div>
</div>