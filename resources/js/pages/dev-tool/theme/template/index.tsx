import Admin from "@/layouts/admin";
import TopOptions from "@/pages/dev-tool/components/top-options";
import {PageTempate, Theme} from "@/types/themes";
import Button from "@/components/form/buttons/button";
import {useState} from "react";
import {__, admin_url, convert_to_label_field, convert_to_name_field, message_in_response} from "@/helpers/functions";
import SuccessButton from "@/components/form/buttons/success-button";
import axios from "axios";
import BlockItem from "@/pages/dev-tool/theme/template/components/block-item";

export interface SettingField extends PageTempate {

}

export default function Index({ theme, settings }: { theme: Theme, settings: Array<SettingField> }) {
    const [customeSettings, setCustomSettings] = useState<Array<SettingField>>(settings);
    const [buttonLoading, setButtonLoading] = useState<boolean>(false);
    const [message, setMessage] = useState<{
        status: boolean,
        message: string
    }>();
    const [labels, setLabels] = useState<Array<string>>([]);
    const [views, setViews] = useState<Array<string>>([]);

    const settingDefaults: SettingField = {
        name: '',
        label: '',
        view: '',
    }

    const handleAddSetting = (e: any) => {
        e.preventDefault();

        setCustomSettings([...customeSettings, settingDefaults]);

        return false;
    }

    const generateLabelByName = (e: any, index: number) => {
        // If the input label is not empty, return
        if (e.target.value === '') {
            return;
        }

        // Format name to be [a-z0-9\-]
        let name = convert_to_name_field(e.target.value);
        let label = convert_to_label_field(name);

        // Set label to the input
        e.target.value = name;
        setLabels({...labels, [index]: label});
        setViews({...views, [index]: `theme::templates.${name}`});

        if (!customeSettings[index+1]) {
            setCustomSettings([...customeSettings, settingDefaults]);
        }
    }

    const handleAddSettingSubmit = (e: any) => {
        e.preventDefault();

        setButtonLoading(true);

        let formData: FormData = new FormData(e.target);

        axios.put(admin_url(`dev-tools/themes/${theme.name}/templates`), formData).then().then((res) => {
            let result = message_in_response(res);
            setButtonLoading(false);
            setMessage(result);
        }).catch((err) => {
            setButtonLoading(false);
            setMessage(message_in_response(err));
        });

        setTimeout(() => {
            setMessage(undefined);
        }, 3000);

        return false;
    }

    return (
        <Admin>
            <TopOptions
                moduleType={'themes'}
                moduleSelected={`themes/${theme.name}`}
                optionSelected={'templates'}
            />

            <div className="row">
                <div className="col-md-12">
                    {message?.message && (
                        <div className={`alert alert-${message.status ? 'success' : 'danger'} jw-message`}>
                            {message.message}
                        </div>
                    )}

                    <form method={'POST'} onSubmit={handleAddSettingSubmit} autoComplete={'off'}>
                        <table className={'table table-bordered'}>
                            <thead>
                                <tr>
                                    <th style={{width: '20%'}}>Template</th>
                                    <th style={{width: '25%'}}>Lable</th>
                                    <th style={{width: '20%'}}>View</th>
                                    <th>Blocks</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                            {customeSettings.map((setting, index) => (
                                <>
                                    <tr key={index}>
                                        <td>
                                            <input
                                                type="text"
                                                className={'form-control'}
                                                name={`settings[${index}][name]`}
                                                defaultValue={setting.name}
                                                onBlur={(e) => generateLabelByName(e, index)}
                                            />
                                        </td>

                                        <td>
                                            <input
                                                type="text"
                                                className={'form-control'}
                                                name={`settings[${index}][label]`}
                                                defaultValue={labels[index] || setting.label}
                                            />
                                        </td>

                                        <td>
                                            <input
                                                type="text"
                                                className={'form-control'}
                                                name={`settings[${index}][view]`}
                                                defaultValue={views[index] || setting.view}
                                            />
                                        </td>

                                        <td>
                                            <BlockItem setting={setting} index={index} />
                                        </td>

                                        <td>
                                            <a href={'#'}
                                               className={'text-danger'}
                                               onClick={() => setCustomSettings(customeSettings.filter((_, i) => i !== index))}>
                                                <i className={'fa fa-trash'}></i> {__('Remove')}
                                            </a>
                                        </td>
                                    </tr>

                                </>
                            ))}
                            </tbody>
                        </table>

                        <Button
                            label={'Add Template'}
                            onClick={handleAddSetting}
                            loading={buttonLoading}
                        />

                        <SuccessButton
                            type={'submit'}
                            label={'Save Changes'}
                            loading={buttonLoading}
                        />
                    </form>
                </div>
            </div>
        </Admin>
    )
}
