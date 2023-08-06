import {Plugin} from "@/types/plugins";
import {Theme} from "@/types/themes";
import Input from "@/components/form/inputs/input";
import Textarea from "@/components/form/inputs/textarea";
import Checkbox from "@/components/form/inputs/checkbox";
import Button from "@/components/form/buttons/button";
import axios from "axios";
import {admin_url} from "@/helpers/functions";

export default function MakeCustomPostType({ module }: { module: Theme | Plugin }) {

    const handleMakeCustomPostType = (e: any ) => {
        e.preventDefault();

        let formData = new FormData(e.target);


        axios.post(admin_url('dev-tools/plugin/' + module.name + '/make-post-type'), formData);

        return false;
    }

    return (
        <div className="row">
            <div className="col-md-12">
                <h5>Make Custom Post Type</h5>

                <form method={'POST'} onSubmit={handleMakeCustomPostType}>
                    <Input name="key" label={'Post Type'} required={true} />

                    <Input name="label" label={'Label'} required={true} />

                    <Textarea name="description" label={'Description'} rows={4} />

                    <Checkbox name={'support[]'} label={'Has Comments'} value={'comment'} />

                    <Checkbox name={'support[]'} label={'Has Category'} value={'category'} />

                    <Checkbox name={'support[]'} label={'Has Tag'} value={'tag'}/>

                    <Button label={'Make Post Type'} type={'submit'} />

                </form>
            </div>
        </div>
    );
}
