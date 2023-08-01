import DataTable from "@/components/DataTable";

export default function Index({ dataTable }) {
    console.log(dataTable);
    return (
        <>
            <DataTable config={dataTable} />
        </>
    );
}
