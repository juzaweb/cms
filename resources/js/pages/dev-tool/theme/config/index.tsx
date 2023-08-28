import Admin from "@/layouts/admin";
import TopOptions from "@/pages/dev-tool/components/top-options";
import {Theme} from "@/types/themes";
import Button from "@/components/form/buttons/button";
import {InputField, InputFieldTypes} from "@/types/fields";
import {useState} from "react";
import {__, admin_url, convert_to_label_field, convert_to_name_field, message_in_response} from "@/helpers/functions";
import SuccessButton from "@/components/form/buttons/success-button";
import axios from "axios";

export interface SettingField extends InputField {
    nameReadonly: boolean,
}

export default function Index({ theme, settings }: { theme: Theme, settings: Array<SettingField> }) {
    const [customeSettings, setCustomSettings] = useState<Array<SettingField>>(settings);
    const [buttonLoading, setButtonLoading] = useState<boolean>(false);
    const [message, setMessage] = useState<{
        status: boolean,
        message: string
    }>();
    const [labels, setLabels] = useState<Array<string>>([]);

    const handleAddSetting = (e: any) => {
        e.preventDefault();

        setCustomSettings([...customeSettings, {
            name: '',
            type: 'string',
            value: '',
            label: '',
            nameReadonly: false
        }]);

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
    }

    const handleAddSettingSubmit = (e: any) => {
        e.preventDefault();

        setButtonLoading(true);

        let formData: FormData = new FormData(e.target);

        axios.put(admin_url(`dev-tools/themes/${theme.name}/settings`), formData).then().then((res) => {
            let result = message_in_response(res);
            setButtonLoading(false);
            setMessage(result);
        }).catch((err) => {
            setButtonLoading(false);
            setMessage(message_in_response(err));
        });

        setTimeout(() => {
            setMessage(undefined);
        }, 2000);

        return false;
    }

    return (
        <Admin>
            <TopOptions
                moduleType={'themes'}
                moduleSelected={`themes/${theme.name}`}
                optionSelected={'settings'}
            />

            <div className="row">
                <div className="col-md-12">
                    {message?.message && (
                        <div className={`alert alert-${message.status ? 'success' : 'danger'} jw-message`}>
                            {message.message}
                        </div>
                    )}

                    <form method={'POST'} onSubmit={handleAddSettingSubmit} autoComplete={'off'}>
                        <table className={'table table-hover'}>
                            <thead>
                                <tr>
                                    <th style={{width: '20%'}}>Config</th>
                                    <th>Lable</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                            {customeSettings.map((setting, index) => (
                                <tr key={index}>
                                    <td>
                                        <input
                                            type="text"
                                            className={'form-control'}
                                            name={`settings[${index}][name]`}
                                            defaultValue={setting.name}
                                            readOnly={setting.nameReadonly}
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
                                        <select
                                            name={`settings[${index}][type]`}
                                            className={'form-control'}
                                            defaultValue={setting.type}
                                        >
                                            {Object.keys(InputFieldTypes).map((type, index) => (
                                                <option key={index} value={type}>{InputFieldTypes[type]}</option>
                                            ))}
                                        </select>
                                    </td>

                                    <td>
                                        <a href={'#'}
                                           className={'text-danger'}
                                           onClick={() => setCustomSettings(customeSettings.filter((_, i) => i !== index))}>
                                            <i className={'fa fa-trash'}></i> {__('Remove')}
                                        </a>
                                    </td>
                                </tr>
                            ))}
                            </tbody>
                        </table>

                        <Button
                            label={'Add Setting'}
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
