import {DatatableColumn, DatatableProps, DatatableSearchField} from "@/types/datatable";
import {__} from "@/helpers/functions";
import BulkActions from "@/components/datatable/bulk-actions";
import Search from "@/components/datatable/search";

export default function DataTable({config}: { config: DatatableProps }) {
    return (
        <>
            <div className="row">
                <BulkActions config={config} />

                <Search config={config} />
            </div>

            <div className="table-responsive">
                <table
                    className="table jw-table"
                    id={config.uniqueId}
                >
                    <thead>
                        <tr>
                            <th data-width="3%" data-checkbox="true">
                                <input type="checkbox" className={'jw-checkbox'} value={'all'} />
                            </th>
                            {config.columns.map((column: DatatableColumn, index: number) => (
                                <th
                                    key={index}
                                    data-width={column.width || 'auto'}
                                    data-align={column.align || 'left'}
                                    data-field={column.key}
                                    data-sortable={column.sortable || true}
                                >{ column.label }
                                </th>
                            ))}
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="checkbox" className={'jw-checkbox'} value={'all'} />
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </>
    );
}
