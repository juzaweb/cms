import {Theme} from "@/types/themes";
import {Plugin} from "@/types/plugins";
import {ModuleData} from "@/pages/dev-tool/types/module";

export default function MenuHandle({module, moduleType, moduleData}: { module: Theme | Plugin, moduleType: string, moduleData: ModuleData }) {
    return (
        <ul className="list-group">
            <li className="list-group-item active">Post Types</li>
        </ul>
    );
}
