import {Plugin, Theme} from "@/types/themes";
import {useEffect, useState} from "react";
import axios from "axios";
import {__, admin_url} from "@/helpers/functions";

export interface IndexProps {
    title: string
    themes: Array<Theme>
    plugins: Array<Plugin>
}

export interface ToolOption {
    key: string
    label: string
}

export default function Index({ themes, plugins }: IndexProps) {
    const [module, setModule] = useState<string>();
    const [selectedOption, setSelectedOption] = useState<string>('');
    const [moduleType, setModuleType] = useState<string>();

    const [moduleData, setModuleData] = useState<{
        configs: {
            options: Array<ToolOption>
        }
    }>();

    useEffect(() => {
        if (module && moduleType) {
            axios.get(admin_url(`dev-tools/module?module=${module}&type=${moduleType}`)).then(({data}) => {
                setModuleData(data);
            });
        }
    }, [module, moduleType])

    const handleModuleChange = (e: any) => {
        let type = e.target.options[e.target.selectedIndex].getAttribute('data-type')?.toString() || '';
        let value = e.target.value;
        setSelectedOption('');

        if (value) {
            setModule(e.target.value);
            setModuleType(type);
        } else {
            setModule(undefined);
            setModuleType(undefined);
            setModuleData(undefined);
        }
    }

    return (
        <>
            <div className={'row'}>
                <div className={'col-md-4'}>
                    <select className={'form-control'} onChange={handleModuleChange}>
                        <option value="">{__('--- Select Module ---')}</option>
                        <optgroup label={__('Themes')}></optgroup>
                        {themes.map((theme: any) => (
                            <option value={theme.name} key={theme.name} data-type={'themes'}>{theme.title}</option>
                        ))}
                        <optgroup label={__('Plugins')}></optgroup>
                        {plugins.map((plugin: any) => (
                            <option value={plugin.name}
                                    key={plugin.name}
                                    data-type={'plugins'}
                            >{plugin.extra?.juzaweb?.name || plugin.name}</option>
                        ))}
                    </select>
                </div>

                <div className="col-md-4">
                    <select className={'form-control'} onChange={(e) => setSelectedOption(e.target.value)}>
                        <option value="" selected={selectedOption == ''}>{__('--- Options ---')}</option>
                        {moduleData && moduleData.configs.options.map((item) => (
                            <option value={item.key} key={item.key} selected={selectedOption == item.key}>{__(item.label)}</option>
                        ))}
                    </select>
                </div>
            </div>
        </>
    );
}
