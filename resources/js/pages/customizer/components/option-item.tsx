export default function OptionItem({item}) {
    return (
        <li title={ item.title }>
            <button className="btn theme-editor-action-list__item" data-bind-event-click="openSection('{{ $id }}')" type="button" name="button">
                <div className="ui-stack ui-stack--alignment-center ui-stack--spacing-none">
                    <div className="ui-stack-item stacked-menu__item-icon stacked-menu__item-icon--small">
                        <div className="theme-editor__icon">
                            <svg className="next-icon next-icon--color-slate-lighter next-icon--size-24">
                                <use xlinkHref="#settings"/>
                            </svg>
                        </div>
                    </div>
                    <div className="ui-stack-item ui-stack-item--fill stacked-menu__item-text">
                        {item.title}
                    </div>
                </div>
            </button>
        </li>
    )
}
