import Admin from "@/layouts/admin";
import TopOptions from "@/pages/dev-tool/components/top-options";
import {Theme} from "@/types/themes";
import Button from "@/components/form/buttons/button";
import {InputField} from "@/types/fields";
import {useState} from "react";
import {__} from "@/helpers/functions";
import SuccessButton from "@/components/form/buttons/success-button";

export default function Index({ theme, settings }: { theme: Theme, settings: Array<InputField> }) {
    const [customeSettings, setCustomSettings] = useState<Array<InputField>>(settings);

    const handleAddSetting = (e: any) => {
        e.preventDefault();

        setCustomSettings([...customeSettings, {
            name: '',
            type: 'string',
            value: '',
            label: '',
        }]);

        return false;
    }

    return (
        <Admin>
            <TopOptions
                moduleType={'themes'}
                moduleSelected={theme.name}
                optionSelected={'settings'}
            />

            <div className="row">
                <div className="col-md-12">
                    <form action="" method={'POST'}>
                        <table className={'table table-hover'}>
                            <thead>
                                <tr>
                                    <th>Config</th>
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
                                            name={`settings[${setting.name}]`}
                                            value={setting.name}
                                        />
                                    </td>

                                    <td>
                                        <input
                                            type="text"
                                            className={'form-control'}
                                            name={`settings[${setting.label}]`}
                                            value={setting.label}
                                        />
                                    </td>

                                    <td>
                                        <select className={'form-control'} defaultValue={setting.type}>
                                            <option value="string">String</option>
                                            <option value="number">Number</option>
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

                        <Button label={'Add Setting'} onClick={handleAddSetting} />
                        <SuccessButton label={'Save Changes'} />
                    </form>
                </div>
            </div>
        </Admin>
    )
}
