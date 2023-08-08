import TopOptions from "@/pages/dev-tool/components/top-options";
import {Plugin} from "@/types/plugins";

export default function Index({ plugin }: { plugin: Plugin }) {
    console.log(plugin);
    return (
        <>

            <TopOptions moduleSelected={plugin.name} />


        </>
    );
}
