import {Theme} from "@/types/themes";
import axios from "axios";
import {admin_url, message_in_response} from "@/helpers/functions";
import {useState} from "react";
import PostTypeForm from "@/pages/dev-tool/components/plugins/post-type-form";
import Admin from "@/layouts/admin";
import TopOptions from "@/pages/dev-tool/components/top-options";

export default function Index({ theme, postTypes }: { theme: Theme, postTypes: Array<any> }) {
    const [buttonLoading, setButtonLoading] = useState<boolean>(false);
    const [message, setMessage] = useState<{
        status: boolean,
        message: string
    }>();

    const handleMakeCustomPostType = (e: any ) => {
        e.preventDefault();

        let formData: FormData = new FormData(e.target);
        let url: string = admin_url(`dev-tools/themes/${theme.name}/post-types`);

        setButtonLoading(true);

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
                optionSelected={'post-types'}
            />

            {/*<div className="row">
                <div className="col-md-12">
                    <table className={'table table-bordered'}>
                        <thead>
                            <tr>
                                <th style={{width: '15%'}}>Actions</th>
                                <th style={{width: '10%'}}>Post Type</th>
                                <th style={{width: '25%'}}>Lable</th>
                                <th>Description</th>
                                <th>Support</th>
                            </tr>
                        </thead>

                        <tbody>
                        {postTypes.map((postType, index) => (
                            <tr key={index}>
                                <td>
                                    <div className="dropdown">
                                        <button
                                            className="btn btn-primary dropdown-toggle"
                                            type="button"
                                            id={`post-type-dropdown-${postType.key}`}
                                            data-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false"
                                        >
                                            Actions
                                        </button>
                                        <div className="dropdown-menu" aria-labelledby={`post-type-dropdown-${postType.key}`}>
                                            <a className="dropdown-item" href="#">Edit</a>
                                        </div>
                                    </div>
                                </td>
                                <td>{postType.key}</td>
                                <td>{postType.label}</td>
                                <td>{postType.description}</td>
                                <td></td>
                            </tr>
                        ))}
                        </tbody>
                    </table>
                </div>
            </div>*/}

            <div className="row">
                <div className="col-md-12">
                    <h5>Make Custom Post Type</h5>

                    {message && (
                        <div className={`alert alert-${message.status ? 'success' : 'danger' } jw-message`}>
                            {message.message}
                        </div>
                    )}

                    <form method={'POST'} onSubmit={handleMakeCustomPostType}>

                        <PostTypeForm buttonLoading={buttonLoading} />

                    </form>
                </div>
            </div>
        </Admin>
    );
}
