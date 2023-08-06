import {__, admin_url} from "@/helpers/functions";
import {useEffect, useState} from "react";
import {Plugin, Theme} from "@/types/themes";
import axios from "axios";

export interface IndexProps {
    title: string
    themes: Array<Theme>
    plugins: Array<Plugin>
}

export interface ToolOption {
    key: string
    label: string
}

export default function Index({themes, plugins}: IndexProps) {
    const [module, setModule] = useState<string>();
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

    return (
        <div className={'row'}>
            <div className={'col-md-4'}>
                <select className={'form-control'} onChange={(e) => {
                    setModule(e.target.value);
                    setModuleType('plugins');
                }}>
                    <option value="">{__('Select Module')}</option>
                    <optgroup label={__('Themes')}></optgroup>
                    {themes.map((theme: any) => (
                        <option value={theme.name} key={theme.name}>{theme.title}</option>
                    ))}
                    <optgroup label={__('Plugins')}></optgroup>
                    {plugins.map((plugin: any) => (
                        <option value={plugin.name}
                                key={plugin.name}>{plugin.extra?.juzaweb?.name || plugin.name}</option>
                    ))}
                </select>
            </div>

            <div className="col-md-4">
                <select name="" className={'form-control'}>
                    <option value="">{__('Options')}</option>
                    {moduleData && moduleData.configs.options.map((item) => (
                        <option value={item.key} key={item.key}>{__(item.label)}</option>
                    ))}
                </select>
            </div>
        </div>
    );
}
