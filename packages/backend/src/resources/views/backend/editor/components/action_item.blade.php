<li title="{{ $title }}">
    <button class="btn theme-editor-action-list__item" data-bind-event-click="openSection('{{ $id }}')" type="button" name="button">
        <div class="ui-stack ui-stack--alignment-center ui-stack--spacing-none">
            <div class="ui-stack-item stacked-menu__item-icon stacked-menu__item-icon--small">
                <div class="theme-editor__icon">
                    <svg class="next-icon next-icon--color-slate-lighter next-icon--size-24"> <use xlink:href="#settings" /> </svg>
                </div>
            </div>
            <div class="ui-stack-item ui-stack-item--fill stacked-menu__item-text">
                {{ $title }}
            </div>
        </div>
    </button>
</li>