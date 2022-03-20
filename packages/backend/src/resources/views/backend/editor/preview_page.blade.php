<section class="theme-editor__preview te-preview__container" component="UI.Preview">
    <header class="te-context-bar">
        <div class="te-top-bar__branding desktop-only hide" bind-show="">
            <a title="Navigate to themes" aria_label="Navigate to themes" class="te-brand-link" data-no-turbolink="true" href="/admin-cp/themes">
                <svg class="ui-inline-svg te-brand-logo" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 42">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#logo-sapo"></use>
                </svg>
            </a>
        </div>
        <div class="te-top-bar__list te-preview-context-bar__inner" data-bind-class="">
            <div class="te-top-bar__item te-top-bar__item--fill te-top-bar__item--bleed">
                <ul class="segmented te-top-bar__button te-viewport-selector desktop-only">
                    <li>
                        <button class="ui-button ui-button--transparent ui-button--icon-only" bind-event-click="changeThemePreviewMode(this)"
                                data-bind-class="{'is-selected': viewportSize == 'mobile'}" data-preview="mobile" data-trekkie-id="mobile" aria-label="Small screen" type="button" name="button">
                            <svg class="next-icon next-icon--size-16 next-icon--flip-horizontal">
                                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#phone"></use>
                            </svg>
                        </button>
                    </li>
                    <li>
                        <button class="ui-button ui-button--transparent ui-button--icon-only" bind-event-click="changeThemePreviewMode(this)"
                                data-bind-class="{'is-selected': viewportSize == 'tablet'}" data-preview="tablet" data-trekkie-id="tablet" aria-label="Tablet screen" type="button" name="button">
                            <svg class="next-icon next-icon--size-16">
                                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#tablet"></use>
                            </svg>
                        </button>
                    </li>
                    <li>
                        <button class="ui-button ui-button--transparent ui-button--icon-only is-selected" bind-event-click="changeThemePreviewMode(this)"
                                data-bind-class="{'is-selected': viewportSize == 'desktop'}" data-preview="desktop" data-trekkie-id="desktop" aria-label="Large screen" type="button" name="button">
                            <svg class="next-icon next-icon--size-16">
                                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#desktop"></use>
                            </svg>
                        </button>
                    </li>

                </ul>
            </div>

            <div class="te-top-bar__item te-status-indicator--live desktop-only">
                Live
            </div>

        </div>
    </header>
    <label class="helper--visually-hidden" for="theme-editor__iframe-wrapper" id="theme-editor__iframe-label">
        <h1>{{ trans('cms::app.preview') }}</h1>
        <p>
            Press Enter to navigate. Click Escape to return to the Edit page.
        </p>
    </label>
    <div class="theme-editor__iframe-wrapper"
         data-bind-class=""
         tabindex="0"
         aria-labelledby="theme-editor__iframe-label" data-preview-window="desktop">
        <iframe id="theme-editor-iframe" class="theme-editor__iframe" scrolling="yes" sandbox="allow-same-origin allow-forms allow-popups allow-scripts allow-modals" tabindex="-1" src="/">
        </iframe>
    </div>
</section>