<form action="{{ route('admin.editor.save') }}" method="post" class="form-ajax" data-success="save_success">
    @csrf

<section class="next-card theme-editor__card card-{{ $id }}">
    <section class="next-card__section">
        {{--<header class="next-card__header theme-setting theme-setting--header">
            <h3 class="ui-subheading">
                {{ $title }}
            </h3>
        </header>--}}

        <div class="card-body mb-3">
            {{ $slot }}
        </div>
    </section>
</section>

<button class="btn btn--full-width mb-2" type="submit">{{ trans('cms::app.save') }}</button>

</form>