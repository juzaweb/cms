import {DatatableColumn, DatatableProps} from "@/types/datatable";
import BulkActions from "@/components/datatable/bulk-actions";
import Search from "@/components/datatable/search";
import {useEffect, useState} from "react";
import axios from "axios";
import BootstrapTable from 'react-bootstrap-table-next';

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



            <BootstrapTable keyField='id' data={ data?.rows } columns={ config.columns } bootstrap4={true} />
        </>
    );
}
