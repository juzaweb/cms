<div class="dz-preview dz-file-preview card mb-3">
    <div class="card-body">
        <form action="" method="post" class="dz-form form-ajax">
            <div class="row">
                <div class="col-md-8"></div>
                <div class="col-md-4 float-right">
                    <div class="form-group">
                        <div class="input-group input-group-sm">
                            <select class="form-control" name="mode" disabled>
                                <option value="public">@lang('Public')</option>
                                <option value="unpublic">@lang('Unpublic')</option>
                                <option value="private">@lang('Private')</option>
                            </select>

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary btn-sm" disabled>
                                    <i class="fas fa-paper-plane"></i> @lang('Save')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <!-- Thumbnail / Icon -->
                <div class="col-md-3 d-flex flex-column align-items-center justify-content-center">
                    <div class="thumb-img mb-3">
                        <i class="fas fa-file-video fa-3x text-secondary"></i>
                    </div>

                    <label class="btn btn-sm btn-primary mb-0 choose-thumbnail-label">
                        {{ __('itube::translation.choose') }}
                        <input type="file" hidden
                               accept="image/*"
                               class="thumbnail-hidden-input"
                        >
                    </label>
                    <input type="hidden" name="thumbnail[path]" class="thumbnail-input">
                    <input type="hidden" name="thumbnail[disk]" class="thumbnail-disk">
                    <span class="thumbnail-error text-danger small"></span>
                </div>

                <!-- File Info & Inputs -->
                <div class="col-md-9">
                    <div class="d-flex justify-content-between mb-1">
                        <strong class="dz-filename text-truncate" style="max-width: 70%;">
                            <span data-dz-name></span>
                        </strong>
                        <small class="text-muted dz-size" data-dz-size></small>
                    </div>

                    <!-- Progress -->
                    <div class="progress mb-2">
                        <div class="progress-bar progress-bar-striped bg-info dz-upload"
                             role="progressbar"
                             aria-valuemin="0" aria-valuemax="100"
                             data-dz-uploadprogress style="width: 0;">
                        </div>
                    </div>

                    <!-- Input fields -->
                    <div class="form-group mb-2">
                        <label for="title-__ID__">@lang('Title')</label>
                        <input type="text" name="title" id="title-__ID__"
                               class="form-control form-control-sm video-title"
                               placeholder="{{ __('itube::translation.video_title') }}"
                               required
                        >
                    </div>
                    <div class="form-group">
                        <label for="description-__ID__">@lang('Description')</label>
                        <textarea name="description"
                                  id="description-__ID__"
                                  class="form-control form-control-sm"
                                  rows="5"
                                  placeholder="{{ __('itube::translation.video_description') }}"></textarea>
                    </div>

                    <div class="more-option">
                        <a href="javascript:void(0);"
                           class="text-secondary float-right small"
                           data-toggle="collapse"
                           data-target="#more-option-fields-__ID__"
                           aria-expanded="false"
                           aria-controls="more-options">
                            <i class="fas fa-plus"></i> @lang('More Options')
                        </a>

                        <div class="more-option-fields collapse" id="more-option-fields-__ID__">
                            <div class="form-group">
                                <label>@lang('Tags')</label>
                                <input type="text"
                                       name="tags[]"
                                       class="form-control form-control-sm"
                                       placeholder="{{ __('itube::translation.video_tags_comma_separated') }}"
                                >
                            </div>

                            <div class="hs-unfold">
                                <a class="js-hs-unfold-invoker dropdown-nav-link remove h-g-primary font-size-14 add-to-playlist"
                                   href="javascript:void(0);"
                                >+ {{ __('itube::translation.playlist') }}</a>

                                <div class="hs-unfold-content dropdown-menu">
                                    <div class="dropdown-item">
                                        <input type="text" class="form-control form-control-sm"
                                               placeholder="{{ __('itube::translation.search_for_a_playlist') }}"
                                               data-playlist-search
                                        >
                                    </div>

                                    <a class="dropdown-item active h-g-primary" href="#">+ {{ __('itube::translation.create_a_playlist') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Error & Status -->
                    <div class="dz-error-message text-danger small mt-1">
                        <span data-dz-errormessage></span>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
