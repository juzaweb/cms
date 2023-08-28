import {__, admin_url} from "@/helpers/functions";
import {useEffect, useRef, useState} from "react";
import axios from "axios";
import {Theme} from "@/types/themes";
import {Plugin} from "@/types/plugins";
import {Configs} from "@/pages/dev-tool/types/module";
import {Link, router, usePage} from "@inertiajs/react";
import Select from "@/components/form/inputs/select";

export default function TopOptions(
    {moduleSelected, moduleType, optionSelected}: {
        moduleSelected?: string,
        moduleType?: string,
        optionSelected?: string
    })
{
    const {url, configs} = usePage<{ url: string, configs: Configs }>().props;
    const [themes, setThemes] = useState<Array<Theme>>();
    const [plugins, setPlugins] = useState<Array<Plugin>>();
    const [customModuleSelected, setCustomModuleSelected] = useState(moduleSelected);
    const [moduleTypeSelected, setModuleTypeSelected] = useState(moduleType);
    const [customOptionSelected, setCustomOptionSelected] = useState(optionSelected);
    const [customConfigs, setCustomConfigs] = useState(configs);

    useEffect(() => {
        axios.get(admin_url(`dev-tools/modules`)).then((res) => {
            setThemes(res.data.themes);
            setPlugins(res.data.plugins);
        });
    }, [url]);

    const handleModuleChange = (val: any) => {
        if (!val) {
            setCustomModuleSelected(undefined);
            return;
        }

        let values = val.value.split('/');
        let type = values[0];
        let value = values.slice(1);

        localStorage.setItem('current_module', value);

        axios.get(admin_url(`dev-tools/module?type=${type}&module=${value}`)).then((res) => {
            setCustomConfigs(res.data.configs);
        })

        setModuleTypeSelected(type);
        setCustomModuleSelected(val.value);
        setCustomOptionSelected(undefined);
    }

    const handleOptionChange = (val: any) => {
        if (!val) {
            setCustomOptionSelected(undefined);
            return;
        }

        let selected = val.value;

        if (selected === customOptionSelected) {
            return;
        }

        localStorage.setItem('current_option', selected);

        if (moduleTypeSelected && selected) {
            router.visit(
                admin_url(`dev-tools/${customModuleSelected}/${selected}`),
                {replace: true}
            );
        }
    }

    const modules: Array<any> = [
        {
            label: 'Themes',
            options: themes?.map((theme: Theme) => (
                {
                    label: theme.title,
                    value: `themes/${theme.name}`,
                }
            )),
        },
        {
            label: 'Plugins',
            options: plugins?.map((plugin: Plugin) => (
                {
                    label: plugin.extra?.juzaweb?.name || plugin.name,
                    value: `plugins/${plugin.name}`,
                }
            )),
        }
    ];

    const options: Array<any> = customConfigs?.options.map((item) => ({
        label: item.label,
        value: item.key
    }));

    return (
        <div className={'row mb-3'}>
            <div className={'col-md-4'}>

                {(themes || plugins) && (
                    <Select
                        name={'module'}
                        placeholder={'Select Module'}
                        value={customModuleSelected}
                        onChange={handleModuleChange}
                        options={modules}
                    />
                )}
            </div>

            <div className="col-md-4">
                <Select
                    placeholder={'Options'}
                    options={options}
                    value={customOptionSelected}
                    onChange={handleOptionChange}
                />
            </div>

            <div className="col-md-4">
                <div className="dropdown">
                    <button className="btn btn-info dropdown-toggle"
                            type="button"
                            id="dropdownMakeButton"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                    >
                        New Module
                    </button>
                    <div className="dropdown-menu" aria-labelledby="dropdownMakeButton">
                        <Link className="dropdown-item"
                              href={admin_url(`dev-tools/themes/create`)}
                        >{__('Make New Theme')}</Link>
                        <Link className="dropdown-item"
                              href={admin_url(`dev-tools/plugins/create`)}
                        >{__('Make New Plugin')}</Link>
                    </div>
                </div>
            </div>
        </div>
    )
}
