import {Plugin} from "@/types/plugins";
import {admin_url, message_in_response, post_request} from "@/helpers/functions";
import {useState} from "react";
import Admin from "@/layouts/admin";
import TopOptions from "@/pages/dev-tool/components/top-options";
import axios from "axios";
import TaxonomyForm from "@/pages/dev-tool/components/plugins/taxonomy-form";

export default function Index({ plugin, postTypes }: { plugin: Plugin, postTypes: Array<any> }) {
    const [buttonLoading, setButtonLoading] = useState<boolean>(false);
    const [message, setMessage] = useState<{
        status: boolean,
        message: string
    }>();

    const handleMakeCustomPostType = (e: any ) => {
        e.preventDefault();

        let url = admin_url('dev-tools/plugins/' + plugin.name + '/taxonomies');
        let formData: FormData = new FormData(e.target);
        setButtonLoading(true);

        // let res = post_request(url, formData);
        // console.log(res);
        setButtonLoading(false);

        axios.post(url, formData)
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
            }).catch((error) => {
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
                optionSelected={'taxonomies'}
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
