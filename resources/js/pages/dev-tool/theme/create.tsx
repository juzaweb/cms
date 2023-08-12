import TopOptions from "@/pages/dev-tool/components/top-options";
import Admin from "@/layouts/admin";
import {useState} from "react";
import Button from "@/components/form/buttons/button";
import Input from "@/components/form/inputs/input";
import Textarea from "@/components/form/inputs/textarea";
import axios from "axios";
import {admin_url, message_in_response} from "@/helpers/functions";

export default function Create() {
    const [buttonLoading, setButtonLoading] = useState<boolean>(false);
    const [message, setMessage] = useState<{
        status: boolean,
        message: string
    }>();
    const [outputBuffer, setOutputBuffer] = useState<string>();

    const handleMakeTheme = (e: any) => {
        e.preventDefault();

        setButtonLoading(true);

        setOutputBuffer(undefined);
        setMessage(undefined);

        let formData: FormData = new FormData(e.target);

        axios.post(admin_url(`dev-tools/themes`), formData).then((res) => {
            let result = message_in_response(res);
            setButtonLoading(false);
            setMessage(result);
            setOutputBuffer(res.data.data.output);

            if (result?.status === true) {
                e.target.reset();
            }
        }).catch((err) => {
            setButtonLoading(false);
            setMessage(message_in_response(err));
        });
    }

    return (
        <Admin>
            <TopOptions
                moduleType={'themes'}
            />

            <div className="row">
                <div className="col-md-12">

                    {message && (
                        <div className={`alert alert-${message.status ? 'success' : 'danger'} jw-message`}>
                            {message.message}
                        </div>
                    )}

                    {outputBuffer && (
                        <pre>{outputBuffer}</pre>
                    )}

                    <form method={'POST'} onSubmit={handleMakeTheme}>

                        <Input
                            name="name"
                            label={'Name'}
                            required={true}
                            description={'Theme name must be unique, only characters a-z 0-9 and -.'}
                        />

                        <Input
                            name="title"
                            label={'Title'}
                            required={true}
                            description={'Title display for the theme.'}
                        />

                        <Textarea
                            name="description"
                            label={'Description'}
                            rows={3}
                            description={'Some description for your theme.'}
                        />

                        <div className="row">
                            <div className="col-md-3">
                                <Input name="author" label={'Author'} required={true}/>
                            </div>

                            <div className="col-md-3">
                                <Input name="version" label={'Version'} required={true} value={'1.0'}/>
                            </div>
                        </div>

                        <Button label={'Create Theme'} type={'submit'} class={'mt-3'} loading={buttonLoading}/>

                    </form>
                </div>
            </div>

        </Admin>
    );
}
