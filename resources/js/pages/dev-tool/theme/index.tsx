import TopOptions from "@/pages/dev-tool/components/top-options";
import Admin from "@/layouts/admin";
import {Theme} from "@/types/themes";

export default function Index({ theme }: { theme: Theme }) {
    return (
        <Admin>

            <TopOptions moduleSelected={theme.name} />


        </Admin>
    );
}
