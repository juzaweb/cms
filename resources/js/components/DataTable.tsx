import {DatatableColumn, DatatableProps} from "@/types/datatable";
import BulkActions from "@/components/datatable/bulk-actions";
import Search from "@/components/datatable/search";
import {useEffect, useState} from "react";
import axios from "axios";

export default function DataTable({config}: { config: DatatableProps }) {
    const [data, setData] = useState<{rows: Array<any>, total: number}>({rows: [], total: 0});

    useEffect(() => {
        axios.get(config.dataUrl).then((res) => {
            setData(res.data);
        });
    }, [config])

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
                            <input
                                type="checkbox"
                                className={'jw-checkbox'}
                                value={'all'}
                                //onChange={() => setCheckedAll(this.checkedAll)}
                            />
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
                    {data && data.rows.map((row: any, index: number) => (
                        <tr>
                            <td>
                                <input
                                    type="checkbox"
                                    name={'ids[]'}
                                    className={'jw-checkbox'} value={row.id}
                                    //checked={checkedAll}
                                />
                            </td>
                            {config.columns.map((column: DatatableColumn, index: number) => (
                                <td
                                    key={index}
                                >
                                    { row[column.key] }
                                </td>
                            ))}
                        </tr>
                    ))}
                    </tbody>
                </table>
            </div>
        </>
    );
}
