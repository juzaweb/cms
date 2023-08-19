import TopOptions from "@/pages/dev-tool/components/top-options";
import Admin from "@/layouts/admin";
import {useState} from "react";
import Button from "@/components/form/buttons/button";
import Input from "@/components/form/inputs/input";
import Textarea from "@/components/form/inputs/textarea";
import axios from "axios";
import {admin_url, convert_to_label_field, convert_to_name_field, message_in_response} from "@/helpers/functions";

export default function Create() {
    const [buttonLoading, setButtonLoading] = useState<boolean>(false);
    const [message, setMessage] = useState<{
        status: boolean,
        message: string
    }>();
    const [outputBuffer, setOutputBuffer] = useState<string>();
    const [label, setLabel] = useState<string>();
    const [domain, setDomain] = useState<string>();

    const generateLabelByName = (e: any) => {
        // If the input label is not empty, return
        if (e.target.value === '') {
            return;
        }

        // Format name to be [a-z0-9\-]
        let name = convert_to_name_field(e.target.value);
        let label = convert_to_label_field(name);

        // Set label to the input
        setLabel(label);
        setDomain(name);
    }

    const handleMakePlugin = (e: any) => {
        e.preventDefault();

        setButtonLoading(true);

        setOutputBuffer(undefined);
        setMessage(undefined);

        let formData: FormData = new FormData(e.target);

        axios.post(admin_url(`dev-tools/plugins`), formData).then((res) => {
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
                moduleType={'plugins'}
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

                    <form method={'POST'} onSubmit={handleMakePlugin}>

                        <div className="row">
                            <div className="col-md-6">
                                <Input
                                    name="name"
                                    label={'Name'}
                                    required={true}
                                    description={'Plugin name must be unique, format: <b>vendor/plugin-name</b>.'}
                                    onBlur={generateLabelByName}
                                />
                            </div>

                            <div className="col-md-6">
                                <Input
                                    name="title"
                                    label={'Title'}
                                    required={true}
                                    description={'Title display for the plugin.'}
                                    value={label}
                                />
                            </div>
                        </div>

                        <Textarea
                            name="description"
                            label={'Description'}
                            rows={3}
                            description={'Some description for your plugin.'}
                        />

                        <div className="row">
                            <div className="col-md-3">
                                <Input
                                    name="domain"
                                    label={'Domain'}
                                    required
                                    value={domain}
                                />
                            </div>

                            <div className="col-md-3">
                                <Input name="author" label={'Author'}/>
                            </div>

                            <div className="col-md-3">
                                <Input name="version" label={'Version'} required={true} value={'1.0'}/>
                            </div>
                        </div>

                        <Button label={'Create Plugin'} type={'submit'} class={'mt-3'} loading={buttonLoading}/>

                    </form>
                </div>
            </div>

        </Admin>
    );
}
