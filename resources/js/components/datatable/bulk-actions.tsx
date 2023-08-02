import {__} from "@/helpers/functions";
import {DatatableAction, DatatableProps} from "@/types/datatable";

export default function BulkActions({config}: { config: DatatableProps }) {
    return (
        config.actions.length > 0 && (
            <div className="col-md-2">
                <form method="post" className="form-inline">
                    <div className="dropdown d-inline-block mb-2 mr-2">
                        <button
                            type="button"
                            className="btn btn-primary dropdown-toggle bulk-actions-button"
                            data-toggle="dropdown"
                            aria-expanded="false">
                            {__('cms::app.bulk_actions')}
                        </button>

                        <div className="dropdown-menu bulk-actions-actions"
                             role="menu"
                             x-placement="bottom-start"
                        >
                            {config.actions.map((action: DatatableAction, index: number) => (
                                <a
                                    className={`dropdown-item select-action action-${action.key}` + (action.key == 'delete' ? ' text-danger' : '')}
                                    href="#"
                                    data-action={action.key}
                                    key={action.key}>
                                    {action.label}
                                </a>
                            ))}
                        </div>
                    </div>
                </form>
            </div>
        )
    );
}
