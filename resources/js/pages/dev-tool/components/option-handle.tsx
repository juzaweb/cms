import {Theme} from "@/types/themes";
import {Plugin} from "@/types/plugins";
import MakeCustomPostType from "@/pages/dev-tool/components/plugins/make-custom-post-type";
import MakeCustomTaxonomy from "@/pages/dev-tool/components/plugins/make-custom-taxonomy";
import MakeCRUD from "@/pages/dev-tool/components/plugins/make-crud";

export default function OptionHandle({module, moduleType, selectedOption}: { module: Theme | Plugin, moduleType: string, selectedOption: string }) {

    switch (selectedOption) {
        case 'make-custom-post-type':
            return <MakeCustomPostType module={module}/>
        case 'make-custom-taxonomy':
            return <MakeCustomTaxonomy module={module}/>
        case 'make-crud':
            return <MakeCRUD module={module}/>
        default: return null;
    }
}
