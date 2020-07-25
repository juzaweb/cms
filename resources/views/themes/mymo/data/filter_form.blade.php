<div class="halim-search-filter">
    <div class="btn-group col-md-12">
        <form action="{{ route('search') }}" id="form-filter" class="form-inline" method="GET">
            <div class="col-md-1 col-xs-12 col-sm-6">
                <div class="filter-box">
                    <div class="filter-box-title">@lang('app.sort')</div>
                    <select class="form-control" id="sort" name="sort">
                        <option value="">@lang('app.sort')</option>
                        <option value="posttime">@lang('app.latest')</option>
                        <option value="viewcount">@lang('app.top_views')</option>
                        <option value="updatetime">@lang('app.new_update')</option>
                    </select>
                </div>
            </div>

            <div class="col-md-1 col-xs-12 col-sm-6">
                <div class="filter-box">
                    <div class="filter-box-title">@lang('app.formats')</div>
                    <select class="form-control" id="type" name="formality">
                        <option value="">@lang('app.formats')</option>
                        <option value="movies">@lang('app.movies')</option>
                        <option value="tv_series">@lang('app.tv_series')</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-xs-12 col-sm-6">
                <div class="filter-box">
                    <div class="filter-box-title">@lang('app.status')</div>
                    <select class="form-control" name="status">
                        <option value="">@lang('app.status')</option>
                        <option value="completed">@lang('app.completed')</option>
                        <option value="ongoing">@lang('app.ongoing')</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-xs-12 col-sm-6">
                <div class="filter-box">
                    <div class="filter-box-title">@lang('app.country')</div>
                    <select class="form-control" name="country">
                        <option value="">@lang('app.country')</option>
                        @foreach($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-1 col-xs-12 col-sm-6">
                <div class="filter-box">
                    <div class="filter-box-title">@lang('app.year')</div>
                    <select class="form-control" name="release">
                        <option value="">@lang('app.year')</option>
                        @foreach($years as $year)
                        <option value="{{ $year->year }}">{{ $year->year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-3 col-xs-12 col-sm-6">
                <div class="filter-box">
                    <div class="filter-box-title">@lang('app.genre')</div>
                    <select class="form-control" id="genre" name="genre">
                        <option value="">@lang('app.genre')</option>
                        @foreach($genres as $genre)
                        <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-xs-12 col-sm-6">
                <button type="submit" id="btn-movie-filter" class="btn btn-danger">@lang('app.filter_movies')</button>
            </div>
        </form>
    </div>
</div>
