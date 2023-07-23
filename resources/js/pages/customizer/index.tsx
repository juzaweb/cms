import {__} from "@/helpers/functions";
import OptionItem from "@/pages/customizer/components/option-item";

export default function Index({ panels }) {
    return (
        <>
            <div id="theme-editor-sidebar">
                <section className="theme-editor__index" component="UI.PanelContainer">
                    <header className="te-top-bar">
                        <div className="te-top-bar__list">
                            <div className="te-top-bar__item te-top-bar__item--fill">
                                <button className="ui-button btn--plain te-panel__header-action" onClick="window.location='{{ route('admin.themes') }}'">
                                    <svg
                                        className="next-icon next-icon--size-20 next-icon--rotate-180 te-panel__header-action-icon">
                                        <use xmlnsXlink="http://www.w3.org/1999/xlink"
                                             xlinkHref="#next-chevron"></use>
                                    </svg>
                                </button>

                                <h2 className="ui-heading theme-editor__heading text-uppercase">
                                    {__('cms::app.theme_editor')}
                                </h2>

                            </div>
                            <div className="te-top-bar__item te-status-indicator--live mobile-only">
                                Live
                            </div>
                        </div>
                    </header>

                    <div className="theme-editor__panel-body">
                        <div className="ui-stack ui-stack--vertical next-tab__panel--grow">
                            <div className="ui-stack-item ui-stack-item--fill">
                                <section className="next-card theme-editor__card">
                                    <ul className="theme-editor-action-list theme-editor-action-list--divided theme-editor-action-list--rounded">
                                        {panels.map((item) => <OptionItem item={item} key={item.key}></OptionItem>)}
                                    </ul>
                                </section>
                            </div>
                        </div>
                    </div>

                    @include('cms::backend.editor.config_option')

                </section>
            </div>

            <section className="theme-editor__preview te-preview__container" component="UI.Preview">
                <header className="te-context-bar">
                    <div className="te-top-bar__branding desktop-only hide" bind-show="">
                        <a title="Navigate to themes" aria_label="Navigate to themes" className="te-brand-link"
                           data-no-turbolink="true" href="/admin-cp/themes">
                            <svg className="ui-inline-svg te-brand-logo" role="img" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 36 42">
                                <use xmlnsXlink="http://www.w3.org/1999/xlink" xlinkHref="#logo-sapo"></use>
                            </svg>
                        </a>
                    </div>
                    <div className="te-top-bar__list te-preview-context-bar__inner" data-bind-class="">
                        <div className="te-top-bar__item te-top-bar__item--fill te-top-bar__item--bleed">
                            <ul className="segmented te-top-bar__button te-viewport-selector desktop-only">
                                <li>
                                    <button className="ui-button ui-button--transparent ui-button--icon-only"
                                            bind-event-click="changeThemePreviewMode(this)"
                                            data-bind-class="{'is-selected': viewportSize == 'mobile'}"
                                            data-preview="mobile" data-trekkie-id="mobile" aria-label="Small screen"
                                            type="button" name="button">
                                        <svg className="next-icon next-icon--size-16 next-icon--flip-horizontal">
                                            <use xmlnsXlink="http://www.w3.org/1999/xlink" xlinkHref="#phone"></use>
                                        </svg>
                                    </button>
                                </li>
                                <li>
                                    <button className="ui-button ui-button--transparent ui-button--icon-only"
                                            bind-event-click="changeThemePreviewMode(this)"
                                            data-bind-class="{'is-selected': viewportSize == 'tablet'}"
                                            data-preview="tablet" data-trekkie-id="tablet" aria-label="Tablet screen"
                                            type="button" name="button">
                                        <svg className="next-icon next-icon--size-16">
                                            <use xmlnsXlink="http://www.w3.org/1999/xlink" xlinkHref="#tablet"></use>
                                        </svg>
                                    </button>
                                </li>
                                <li>
                                    <button
                                        className="ui-button ui-button--transparent ui-button--icon-only is-selected"
                                        bind-event-click="changeThemePreviewMode(this)"
                                        data-bind-class="{'is-selected': viewportSize == 'desktop'}"
                                        data-preview="desktop" data-trekkie-id="desktop" aria-label="Large screen"
                                        type="button" name="button">
                                        <svg className="next-icon next-icon--size-16">
                                            <use xmlnsXlink="http://www.w3.org/1999/xlink" xlinkHref="#desktop"></use>
                                        </svg>
                                    </button>
                                </li>

                            </ul>
                        </div>

                        <div className="te-top-bar__item te-status-indicator--live desktop-only">
                            Live
                        </div>

                    </div>
                </header>

                <label className="helper--visually-hidden" htmlFor="theme-editor__iframe-wrapper"
                       id="theme-editor__iframe-label">
                    <h1>{__('cms::app.preview')}</h1>
                    <p>
                        Press Enter to navigate. Click Escape to return to the Edit page.
                    </p>
                </label>

                <div className="theme-editor__iframe-wrapper"
                     data-bind-class=""
                     tabIndex="0"
                     aria-labelledby="theme-editor__iframe-label" data-preview-window="desktop">
                    <iframe id="theme-editor-iframe" className="theme-editor__iframe"
                            sandbox="allow-same-origin allow-forms allow-popups allow-scripts allow-modals"
                            tabIndex="-1" src="/">
                    </iframe>
                </div>
            </section>
        </>
    )
}
