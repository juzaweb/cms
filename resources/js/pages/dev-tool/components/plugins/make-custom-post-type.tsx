import {Plugin} from "@/types/plugins";
import {Theme} from "@/types/themes";
import Input from "@/components/form/inputs/input";
import Textarea from "@/components/form/inputs/textarea";

export default function MakeCustomPostType({ module }: { module: Theme | Plugin }) {
    return (
        <div className="row">
            <div className="col-md-12">
                <h5>Make Custom Post Type</h5>

                <form method={'POST'}>
                    <Input name="label" label={'Label'} />

                    <Textarea name="description" label={'Description'} rows={4} />
                </form>
            </div>
        </div>
    );
}
