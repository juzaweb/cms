import {Theme} from "@/types/themes";
import axios from "axios";
import {admin_url, message_in_response} from "@/helpers/functions";
import {useState} from "react";
import TaxonomyForm from "@/pages/dev-tool/components/plugins/taxonomy-form";
import Admin from "@/layouts/admin";
import TopOptions from "@/pages/dev-tool/components/top-options";

export default function Create({ theme, postTypes }: { theme: Theme, postTypes: Array<any> }) {
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
            admin_url('dev-tools/themes/' + theme.name + '/taxonomies'),
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
        <Admin>
            <TopOptions
                moduleSelected={`themes/${theme.name}`}
                moduleType={'themes'}
                optionSelected={'taxonomies/create'}
            />

            <div className="row">
                <div className="col-md-12">
                    <h5>Make Custom Taxonomy</h5>

                    {message && (
                        <div className={`alert alert-${message.status ? 'success' : 'danger' } jw-message`}>
                            {message.message}
                        </div>
                    )}

                    <form method={'POST'} onSubmit={handleMakeCustomPostType}>

                        <TaxonomyForm buttonLoading={buttonLoading} postTypes={postTypes} />

                    </form>
                </div>
            </div>
        </Admin>
    );
}
