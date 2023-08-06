import {Plugin} from "@/types/plugins";
import {Theme} from "@/types/themes";
import Input from "@/components/form/inputs/input";
import Textarea from "@/components/form/inputs/textarea";
import Checkbox from "@/components/form/inputs/checkbox";
import Button from "@/components/form/buttons/button";
import axios from "axios";
import {admin_url} from "@/helpers/functions";
import {useState} from "react";

export default function MakeCustomPostType({ module }: { module: Theme | Plugin }) {
    const [buttonLoading, setButtonLoading] = useState<boolean>(false);

    const handleMakeCustomPostType = (e: any ) => {
        e.preventDefault();

        let formData: FormData = new FormData(e.target);
        setButtonLoading(true);

        axios.post(
            admin_url('dev-tools/plugin/' + module.name + '/make-post-type'),
            formData,
            {
                headers: {
                    'Content-Type': 'application/json',
                },
            }
        )
            .then((response) => {
                setButtonLoading(false);
                if (response.data.status === true) {
                    e.target.reset();
                }
            });

        return false;
    }

    return (
        <div className="row">
            <div className="col-md-12">
                <h5>Make Custom Post Type</h5>

                <form method={'POST'} onSubmit={handleMakeCustomPostType}>

                    <Input name="key" label={'Post Type'} required={true} />

                    <Input name="label" label={'Label'} required={true} />

                    <Textarea name="description" label={'Description'} rows={3} />

                    <Checkbox name={'support[]'} label={'Has Comments'} value={'comment'} />

                    <Checkbox name={'support[]'} label={'Has Category'} value={'category'} />

                    <Checkbox name={'support[]'} label={'Has Tag'} value={'tag'}/>

                    <Checkbox name={'show_in_menu'} label={'Show In Menu'} checked={true} />

                    <Button label={'Make Post Type'} type={'submit'} loading={buttonLoading} />

                </form>
            </div>
        </div>
    );
}
