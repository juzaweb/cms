import {getSidebar} from "@/helpers/fetch";
import {useState} from "react";
import Show from "../widgets/banner/show";

export default function DynamicSidebar() {
    const [sidebar, setSidebar] = useState<{config: Array<any>}>();

    getSidebar('sidebar').then(
        (res) => {
            setSidebar(res.data);
        }
    );

    return sidebar && sidebar.config && sidebar.config.map((item: any) => {
        switch (item.widget) {
            case 'banner':
                return <Show key={item.id} data={item} />
            default:
                return '';
        }
    });
}
