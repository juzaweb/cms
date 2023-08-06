import {Plugin} from "@/types/plugins";
import {Theme} from "@/types/themes";
import Input from "@/components/form/inputs/input";
import Textarea from "@/components/form/inputs/textarea";
import Checkbox from "@/components/form/inputs/checkbox";
import Button from "@/components/form/inputs/button";

export default function MakeCustomPostType({ module }: { module: Theme | Plugin }) {

    const handleMakeCustomPostType = () => {
        console.log('make custom post type');
    }

    return (
        <div className="row">
            <div className="col-md-12">
                <h5>Make Custom Post Type</h5>

                <form method={'POST'} onSubmit={handleMakeCustomPostType}>
                    <Input name="key" label={'Post Type'} required={true} />

                    <Input name="label" label={'Label'} required={true} />

                    <Textarea name="description" label={'Description'} rows={4} />

                    <Checkbox name={'support[category]'} label={'Support Category'}/>

                    <Checkbox name={'support[tag]'} label={'Support Tag'}/>

                    <Button label={'Save'} type={'submit'} />

                </form>
            </div>
        </div>
    );
}
