<div class="mymo-search-filter">
    <div class="btn-group col-md-12">
        <form action="{{ route('search') }}" id="form-filter" class="form-inline" method="GET">
            <div class="col-md-1 col-xs-12 col-sm-6">
                <div class="filter-box">
                    <div class="filter-box-title">@lang('theme::app.sort')</div>
                    <select class="form-control" id="sort" name="sort">
                        <option value="">@lang('theme::app.sort')</option>
                        <option value="latest">@lang('theme::app.latest')</option>
                        <option value="top_views">@lang('theme::app.top_views')</option>
                        <option value="new_update">@lang('theme::app.new_update')</option>
                    </select>
                </div>
            </div>

            <div class="col-md-1 col-xs-12 col-sm-6">
                <div class="filter-box">
                    <div class="filter-box-title">@lang('theme::app.formats')</div>
                    <select class="form-control" id="type" name="formality">
                        <option value="">@lang('theme::app.formats')</option>
                        <option value="1">@lang('theme::app.movies')</option>
                        <option value="2">@lang('theme::app.tv_series')</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-xs-12 col-sm-6">
                <div class="filter-box">
                    <div class="filter-box-title">@lang('theme::app.status')</div>
                    <select class="form-control" name="status">
                        <option value="">@lang('theme::app.status')</option>
                        <option value="completed">@lang('theme::app.completed')</option>
                        <option value="ongoing">@lang('theme::app.ongoing')</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-xs-12 col-sm-6">
                <div class="filter-box">
                    <div class="filter-box-title">@lang('theme::app.country')</div>
                    <select class="form-control" name="country">
                        <option value="">@lang('theme::app.country')</option>
                        @foreach($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-1 col-xs-12 col-sm-6">
                <div class="filter-box">
                    <div class="filter-box-title">@lang('theme::app.year')</div>
                    <select class="form-control" name="release">
                        <option value="">@lang('theme::app.year')</option>
                        @foreach($years as $year)
                        <option value="{{ $year->year }}">{{ $year->year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-3 col-xs-12 col-sm-6">
                <div class="filter-box">
                    <div class="filter-box-title">@lang('theme::app.genre')</div>
                    <select class="form-control" id="genre" name="genre">
                        <option value="">@lang('theme::app.genre')</option>
                        @foreach($genres as $genre)
                        <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-xs-12 col-sm-6">
                <button type="submit" id="btn-movie-filter" class="btn btn-danger">@lang('theme::app.filter_movies')</button>
            </div>
        </form>
    </div>
</div>
