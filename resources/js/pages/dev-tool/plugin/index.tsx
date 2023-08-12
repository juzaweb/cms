import TopOptions from "@/pages/dev-tool/components/top-options";
import {Plugin} from "@/types/plugins";
import Admin from "@/layouts/admin";

export default function Index({ plugin }: { plugin: Plugin }) {

    return (
        <Admin>

            <TopOptions moduleSelected={plugin.name} />


        </Admin>
    );
}
