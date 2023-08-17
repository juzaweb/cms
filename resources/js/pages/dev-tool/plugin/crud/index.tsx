import {Plugin} from "@/types/plugins";
import axios from "axios";
import {admin_url, message_in_response} from "@/helpers/functions";
import {useState} from "react";
import Input from "@/components/form/inputs/input";
import Button from "@/components/form/buttons/button";
import Checkbox from "@/components/form/inputs/checkbox";
import Admin from "@/layouts/admin";
import TopOptions from "@/pages/dev-tool/components/top-options";

export default function Index({ plugin }: { plugin: Plugin }) {
    const [buttonLoading, setButtonLoading] = useState<boolean>(false);
    const [message, setMessage] = useState<{
        status: boolean,
        message: string
    }>();
    const [bufferedOutput, setBufferedOutput] = useState<string>();

    const handleMakeCustomPostType = (e: any ) => {
        e.preventDefault();

        let formData: FormData = new FormData(e.target);
        setBufferedOutput(undefined);
        setButtonLoading(true);

        axios.post(
            admin_url('dev-tools/plugins/' + plugin.name + '/crud'),
            formData
        )
            .then((response) => {
                let result = message_in_response(response);
                setButtonLoading(false);
                setMessage(result);
                setBufferedOutput(response.data.data.output);
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
        <Admin>
            <TopOptions
                moduleSelected={`plugins/${plugin.name}`}
                moduleType={'plugins'}
                optionSelected={'crud'}
            />

            <div className="row">
                <div className="col-md-12">
                    <h5>Make CRUD</h5>

                    {message && (
                        <div className={`alert alert-${message.status ? 'success' : 'danger' } jw-message`}>
                            {message.message}
                        </div>
                    )}

                    {bufferedOutput && (
                        <pre className="jw-pre">{bufferedOutput}</pre>
                    )}

                    <form method={'POST'} onSubmit={handleMakeCustomPostType}>

                        <div className={'row'}>
                            <div className="col-md-9">
                                <Input name="table" label={'Table'} required={true}/>

                                <Input name="label" label={'Label'} />

                                <Button label={'Make CRUD'} type={'submit'} loading={buttonLoading}/>
                            </div>

                            <div className="col-md-3">
                                <Checkbox name={'make_menu'} label={'Make Menu'} checked={true}/>

                                <Input name="menu_position" label={'Menu Position'} type={'number'} value={'20'}/>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </Admin>
    );
}
