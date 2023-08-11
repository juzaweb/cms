import TopOptions from "@/pages/dev-tool/components/top-options";
import Admin from "@/layouts/admin";
import {useState} from "react";
import Button from "@/components/form/buttons/button";
import Input from "@/components/form/inputs/input";
import Textarea from "@/components/form/inputs/textarea";

export default function Create() {
    const [buttonLoading, setButtonLoading] = useState<boolean>(false);
    const [message, setMessage] = useState<{
        status: boolean,
        message: string
    }>();

    const handleMakeTheme = (e: any ) => {
        e.preventDefault();

    }

    return (
        <Admin>
            <TopOptions
                moduleType={'themes'}
            />

            <div className="row">
                <div className="col-md-12">

                    {message && (
                        <div className={`alert alert-${message.status ? 'success' : 'danger' } jw-message`}>
                            {message.message}
                        </div>
                    )}

                    <form method={'POST'} onSubmit={handleMakeTheme}>

                        <Input name="name" label={'Name'} required={true}/>

                        <Input name="title" label={'Title'} required={true}/>

                        <Textarea name="description" label={'Description'} rows={3} />

                        <Input name="author" label={'Author'}/>

                        <Input name="version" label={'Version'} required={true} value={'1.0'}/>

                        <Button label={'Create Theme'} type={'submit'} loading={buttonLoading}/>

                    </form>
                </div>
            </div>

        </Admin>
    );
}
