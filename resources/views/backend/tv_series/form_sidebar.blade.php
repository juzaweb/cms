<div class="form-group">
    <label class="col-form-label" for="thumbnail">@lang('app.thumbnail')</label>
    <div class="form-thumbnail text-center">
        <input id="thumbnail" type="hidden" name="thumbnail">
        <div id="holder">
            <img src="{{ $model->getThumbnail() }}" class="w-100">
        </div>

        <a href="javascript:void(0)" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-capitalize lfm">
            <i class="fa fa-picture-o"></i> @lang('app.choose_image')
        </a>
    </div>
</div>

<div class="form-group">
    <label class="col-form-label" for="poster">@lang('app.poster')</label>
    <div class="form-thumbnail text-center">
        <input id="poster" type="hidden" name="poster" value="{{ $model->poster }}">
        <div id="holder-poster">
            <img src="{{ $model->getPoster() }}" class="w-100">
        </div>

        <a href="javascript:void(0)" data-input="poster" data-preview="holder-poster" class="btn btn-primary text-capitalize lfm">
            <i class="fa fa-picture-o"></i> @lang('app.choose_image')
        </a>
    </div>
</div>

<hr>
<div class="form-group">
    <label class="col-form-label" for="select-genres">@lang('app.genres') <span><a href="javascript:void(0)" class="add-new-genres float-right"><i class="fa fa-plus-circle"></i> @lang('app.add_genres')</a></span></label>

    <select id="select-genres" class="form-control load-genres select-genres" data-placeholder="--- @lang('app.genres') ---" data-explodes="genres-explode"></select>

    <div class="show-genres mt-2">
        @foreach($genres as $item)
            <span class="tag m-1">{{ $item->name }} <a href="javascript:void(0)" class="text-danger ml-1 remove-tag-item"><i class="fa fa-times-circle"></i></a>
  <input type="hidden" name="genres[]" class="genres-explode" value="{{ $item->id }}">
</span>
        @endforeach
    </div>

    <div class="form-add-genres box-hidden">
        <div class="form-group">
            <label class="col-form-label" for="tagsName">@lang('app.genre')</label>
            <input type="text" class="form-control" id="genresName" autocomplete="off">
        </div>

        <button type="button" class="btn btn-primary add-genres"><i class="fa fa-plus-circle"></i> @lang('app.add_genre')</button>
    </div>
</div>

<hr>
<div class="form-group">
    <label class="col-form-label" for="select-countries">@lang('app.countries') <span><a href="javascript:void(0)" class="add-new-countries float-right"><i class="fa fa-plus-circle"></i> @lang('app.add_countries')</a></span></label>

    <select id="select-countries" class="form-control load-countries select-countries" data-placeholder="--- @lang('app.countries') ---" data-explodes="countries-explode"></select>

    <div class="show-countries mt-2">
        @foreach($countries as $item)
            <span class="tag m-1">{{ $item->name }} <a href="javascript:void(0)" class="text-danger ml-1 remove-tag-item"><i class="fa fa-times-circle"></i></a>
  <input type="hidden" name="countries[]" class="countries-explode" value="{{ $item->id }}">
</span>
        @endforeach
    </div>

    <div class="form-add-countries box-hidden">
        <div class="form-group">
            <label class="col-form-label" for="countriesName">@lang('app.countries')</label>
            <input type="text" class="form-control" id="countriesName" autocomplete="off">
        </div>

        <button type="button" class="btn btn-primary add-countries"><i class="fa fa-plus-circle"></i> @lang('app.add_countries')</button>
    </div>
</div>

<hr>
<div class="form-group">
    <label class="col-form-label" for="select-actors">@lang('app.actors') <span><a href="javascript:void(0)" class="add-new-actors float-right"><i class="fa fa-plus-circle"></i> @lang('app.add_actors')</a></span></label>

    <select id="select-actors" class="form-control load-actors select-actors" data-placeholder="--- @lang('app.actors') ---" data-explodes="actors-explode"></select>

    <div class="show-actors mt-2">
        @foreach($actors as $item)
            <span class="tag m-1">{{ $item->name }} <a href="javascript:void(0)" class="text-danger ml-1 remove-tag-item"><i class="fa fa-times-circle"></i></a>
  <input type="hidden" name="actors[]" class="actors-explode" value="{{ $item->id }}">
</span>
        @endforeach
    </div>

    <div class="form-add-actors box-hidden">
        <div class="form-group">
            <label class="col-form-label" for="actorsName">@lang('app.actors')</label>
            <input type="text" class="form-control" id="actorsName" autocomplete="off">
        </div>

        <button type="button" class="btn btn-primary add-actors"><i class="fa fa-plus-circle"></i> @lang('app.add_actor')</button>
    </div>
</div>

<hr>
<div class="form-group">
    <label class="col-form-label" for="select-directors">@lang('app.directors') <span><a href="javascript:void(0)" class="add-new-directors float-right"><i class="fa fa-plus-circle"></i> @lang('app.add_directors')</a></span></label>

    <select id="select-directors" class="form-control load-directors select-directors" data-placeholder="--- @lang('app.directors') ---" data-explodes="directors-explode"></select>

    <div class="show-directors mt-2">
        @foreach($directors as $item)
            <span class="tag m-1">{{ $item->name }} <a href="javascript:void(0)" class="text-danger ml-1 remove-tag-item"><i class="fa fa-times-circle"></i></a>
  <input type="hidden" name="directors[]" class="directors-explode" value="{{ $item->id }}">
</span>
        @endforeach
    </div>

    <div class="form-add-directors box-hidden">
        <div class="form-group">
            <label class="col-form-label" for="directorsName">@lang('app.directors')</label>
            <input type="text" class="form-control" id="directorsName" autocomplete="off">
        </div>

        <button type="button" class="btn btn-primary add-directors"><i class="fa fa-plus-circle"></i> @lang('app.add_director')</button>
    </div>
</div>

<hr>
<div class="form-group">
    <label class="col-form-label" for="select-writers">@lang('app.writers') <span><a href="javascript:void(0)" class="add-new-writers float-right"><i class="fa fa-plus-circle"></i> @lang('app.add_writers')</a></span></label>

    <select id="select-writers" class="form-control load-writers select-writers" data-placeholder="--- @lang('app.writers') ---" data-explodes="writers-explode"></select>

    <div class="show-writers mt-2">
        @foreach($writers as $item)
            <span class="tag m-1">{{ $item->name }} <a href="javascript:void(0)" class="text-danger ml-1 remove-tag-item"><i class="fa fa-times-circle"></i></a>
  <input type="hidden" name="writers[]" class="writers-explode" value="{{ $item->id }}">
</span>
        @endforeach
    </div>

    <div class="form-add-writers box-hidden">
        <div class="form-group">
            <label class="col-form-label" for="writersName">@lang('app.writers')</label>
            <input type="text" class="form-control" id="writersName" autocomplete="off">
        </div>

        <button type="button" class="btn btn-primary add-writers"><i class="fa fa-plus-circle"></i> @lang('app.add_writer')</button>
    </div>
</div>

<hr>
<div class="form-group">
    <label class="col-form-label" for="select-tags">@lang('app.tags') <span><a href="javascript:void(0)" class="add-new-tags float-right"><i class="fa fa-plus-circle"></i> @lang('app.add_tags')</a></span></label>

    <select id="select-tags" class="form-control load-tags select-tags" data-placeholder="--- @lang('app.tags') ---" data-explodes="tags-explode"></select>

    <div class="show-tags mt-2">
        @foreach($tags as $item)
            <span class="tag m-1">{{ $item->name }} <a href="javascript:void(0)" class="text-danger ml-1 remove-tag-item"><i class="fa fa-times-circle"></i></a>
  <input type="hidden" name="tags[]" class="tags-explode" value="{{ $item->id }}">
</span>
        @endforeach
    </div>

    <div class="form-add-tags box-hidden">
        <div class="form-group">
            <label class="col-form-label" for="tagsName">@lang('app.tags')</label>
            <input type="text" class="form-control" id="tagsName" autocomplete="off">
        </div>

        <button type="button" class="btn btn-primary add-tags"><i class="fa fa-plus-circle"></i> @lang('app.add_tags')</button>
    </div>
</div>