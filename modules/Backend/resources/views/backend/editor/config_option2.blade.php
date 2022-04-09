<div class="theme-editor__panel-body">
    <div class="ui-stack ui-stack--vertical next-tab__panel--grow">
        <div class="ui-stack-item ui-stack-item--fill">
            <section class="next-card theme-editor__card">
                <ul class="theme-editor-action-list theme-editor-action-list--divided theme-editor-action-list--rounded">
                    @foreach($config as $index => $item)
                        <li title="{{ $item['name'] }}">
                            <button class="btn theme-editor-action-list__item" data-bind-event-click="openSection({{ $index }})" type="button" name="button">
                                <div class="ui-stack ui-stack--alignment-center ui-stack--spacing-none">
                                    <div class="ui-stack-item stacked-menu__item-icon stacked-menu__item-icon--small">
                                        <div class="theme-editor__icon">
                                            <svg class="next-icon next-icon--color-slate-lighter next-icon--size-24"> <use xlink:href="#settings" /> </svg>
                                        </div>
                                    </div>
                                    <div class="ui-stack-item ui-stack-item--fill stacked-menu__item-text">
                                        {{ $item['name'] }}
                                    </div>
                                </div>
                            </button>
                        </li>
                    @endforeach
                </ul>
            </section>
        </div>
    </div>
</div>


@foreach($config as $index => $item)
    @php
        $options = theme_config($item['code']);
    @endphp
    <div class="theme-editor__panel" id="panel-{{ $index }}" tabindex="-1">
        <header class="te-panel__header">
            <button class="ui-button btn--plain te-panel__header-action" data-bind-event-click="closeSection()" data-trekkie-id="close-panel" aria-label="Back to theme settings" type="button" name="button">
                <svg class="next-icon next-icon--size-20 next-icon--rotate-180 te-panel__header-action-icon">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#next-chevron"></use>
                </svg>
            </button>
            <h2 class="ui-heading theme-editor__heading">{{ $item['name'] }}</h2>

        </header>

        <div class="theme-editor__panel-body" data-scrollable>
            <form action="{{ route('admin.editor.save') }}" method="post" class="form-ajax" data-success="save_success">
                @csrf

                <button class="btn btn-save-top" type="submit">{{ trans('cms::app.save') }}</button>

                <input type="hidden" name="code" value="{{ $item['code'] }}">

                @if(isset($item['cards']))
                    @foreach($item['cards'] as $icard => $card)
                        @php
                            $option_card = @$options[$card['code']];
                        @endphp
                        <section class="next-card theme-editor__card card-{{ $index }}-{{ $icard }}">
                            <section class="next-card__section">

                                <header class="next-card__header theme-setting theme-setting--header">
                                    <h3 class="ui-subheading">{{ $card['name'] }} <a href="javascript:void(0)" class="show-card-body"><i class="fa fa-eye"></i> {{ trans('cms::app.show') }}</a></h3>
                                </header>

                                <div class="card-body">
                                    <input type="hidden" name="{{ $card['code'] }}[code]" value="{{ $card['code'] }}">

                                    @if(isset($card['status']))

                                        <div class="theme-setting theme-setting--text editor-item">
                                            <div class="next-input-wrapper">
                                                <div class="checkbox" id="setting-checkbox-favicon_enable">
                                                    <label class="next-label next-label--switch">
                                                        {{ trans('cms::app.enabled') }}
                                                    </label>
                                                    <input type="checkbox" class="next-checkbox check-status" {{ (isset($option_card['status']) && (int) $option_card['status'] == 1) ? 'checked' : '' }}>
                                                    <input type="hidden" name="{{ $card['code'] }}[status]" class="check-status-hide" value="{{ isset($option_card['status']) ? (int) $option_card['status'] : 0 }}">
                                                    <span class="next-checkbox--styled">
                                                        <svg class="next-icon next-icon--size-10 checkmark">
                                                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#next-checkmark-thick"></use>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                    @endif
                                    @if(isset($card['input_items']))
                                        @foreach($card['input_items'] as $iinput => $input)
                                            @if(in_array($input['element'], ['input', 'textarea', 'media', 'slider', 'select_genre', 'select_genres']))

                                                @include('cms::backend.editor.boxs.input_box')

                                            @else

                                                @include('cms::backend.editor.boxs.'. $input['element'] .'_box')

                                            @endif

                                        @endforeach
                                    @endif


                                </div>
                            </section>
                        </section>
                    @endforeach
                @endif

                <button class="btn btn--full-width" type="submit">{{ trans('cms::app.save') }}</button>
            </form>
        </div>
    </div>
@endforeach
