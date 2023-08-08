import {DatatableProps, DatatableSearchField} from "@/types/datatable";
import {__} from "@/helpers/functions";

export default function Search({config}: { config: DatatableProps }) {
    return (
        config.searchable && (
            <div className="col-md-10">
                <form method="get" className="form-inline" id="form-search">
                    {config.searchFields.map((field: DatatableSearchField, index: number) => (
                        <input
                            type="text"
                            name={field.type}
                            className="form-control mb-2 mr-2"
                            placeholder={__('cms::app.search')}
                            key={index}
                        />
                    ))}

                    <button type="submit" className="btn btn-primary mb-2">
                        <i className="fa fa-search"></i> {__('cms::app.search')}
                    </button>
                </form>
            </div>
        )
    );
}
