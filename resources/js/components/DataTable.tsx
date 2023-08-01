import {DatatableProps} from "@/types/datatable";
import {__} from "@/helpers/functions";

export default function DataTable({config}: { config: DatatableProps }) {
    return (
        <>
            <div className="row">
                <>
                    {config.actions.length > 0 && (
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
                                        {config.actions.map((action, index) => (
                                            <a className={`dropdown-item select-action action-${action.key}` + (action.key == 'delete' ? ' text-danger' : '')} href="#" data-action={action.key} key={action.key}>{action.label}</a>
                                        ))}
                                    </div>
                                </div>
                            </form>
                        </div>
                    )}

                    {config.searchable && (
                        <div className="col-md-10">
                            <form method="get" className="form-inline" id="form-search">
                                {config.searchFields.map((field, index) => (
                                    <input type="text" name={field.type}
                                           className="form-control mb-2 mr-2"
                                           placeholder={__('cms::app.search')}
                                           key={index}/>
                                ))}

                                <button type="submit" className="btn btn-primary mb-2">
                                    <i className="fa fa-search"></i> {__('cms::app.search')}
                                </button>
                            </form>
                        </div>
                    )}
                </>
            </div>
        </>
    );
}
