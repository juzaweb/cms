import {Plugin} from "@/types/plugins";
import {Theme} from "@/types/themes";
import Input from "@/components/form/inputs/input";
import Textarea from "@/components/form/inputs/textarea";
import Checkbox from "@/components/form/inputs/checkbox";
import Button from "@/components/form/buttons/button";
import axios from "axios";
import {admin_url, message_in_response} from "@/helpers/functions";
import {useState} from "react";

export default function MakeCustomPostType({ module }: { module: Theme | Plugin }) {
    const [buttonLoading, setButtonLoading] = useState<boolean>(false);
    const [message, setMessage] = useState<{
        status: boolean,
        message: string
    }>();

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
                let result = message_in_response(response);
                setButtonLoading(false);
                setMessage(result);
                if (result?.status === true) {
                    e.target.reset();
                }

                setTimeout(() => {
                    setMessage(undefined);
                }, 2000);
            })
            .catch((error) => {
                setMessage(message_in_response(error));
                setButtonLoading(false);
                setTimeout(() => {
                    setMessage(undefined);
                }, 2000);
            });

        return false;
    }

    return (
        <div className="row">
            <div className="col-md-12">
                <h5>Make Custom Post Type</h5>

                {message && (
                    <div className={`alert alert-${message.status ? 'success' : 'danger' } jw-message`}>
                        {message.message}
                    </div>
                )}

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
