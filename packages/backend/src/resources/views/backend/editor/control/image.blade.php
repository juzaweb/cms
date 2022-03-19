<label class="next-label" for="input-{{ $key }}">{{ $args->get('label') }}</label>
<div class="review" id="review-{{ $key }}">
    <img src="{{ upload_url(get_theme_mod($args->get('settings'))) }}" alt="">
</div>

<p><a href="javascript:void(0)" class="load-media" data-input="input-{{ $key }}" data-preview="review-{{ $key }}"><i class="fa fa-edit"></i> {{ trans('cms::app.change') }}</a></p>
<input type="hidden" name="theme[{{ $args->get('settings') }}]" id="input-{{ $key }}" value="{{ get_theme_mod($args->get('settings')) }}">