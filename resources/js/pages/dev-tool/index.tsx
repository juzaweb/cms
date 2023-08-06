import {Theme} from "@/types/themes";
import {useEffect, useState} from "react";
import axios from "axios";
import {__, admin_url} from "@/helpers/functions";
import OptionHandle from "@/pages/dev-tool/components/option-handle";
import {Plugin} from "@/types/plugins";
import MenuHandle from "@/pages/dev-tool/components/menu-handle";
import {ModuleData} from "@/pages/dev-tool/types/module";

export interface IndexProps {
    title: string
    themes: Array<Theme>
    plugins: Array<Plugin>
}

export default function Index({ themes, plugins }: IndexProps) {
    const [module, setModule] = useState<Theme|Plugin>();
    const [selectedOption, setSelectedOption] = useState<string>('');
    const [moduleType, setModuleType] = useState<string>();
    const [moduleData, setModuleData] = useState<ModuleData>();

    useEffect(() => {
        if (module && moduleType) {
            axios.get(admin_url(`dev-tools/module?module=${module.name}&type=${moduleType}`)).then(({data}) => {
                setModuleData(data);
            });
        }
    }, [module, moduleType])

    const handleModuleChange = (e: any) => {
        let type = e.target.options[e.target.selectedIndex].getAttribute('data-type')?.toString() || '';
        let value = e.target.value;
        setSelectedOption('');

        if (value) {
            setModuleType(type);
            if (type === 'plugins') {
                setModule(plugins.find((plugin: Plugin) => plugin.name === value));
            } else {
                setModule(themes.find((theme: Theme) => theme.name === value));
            }
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

            <div className="row mt-3">
                {/*<div className="col-md-3">
                    {module && moduleType && moduleData && <MenuHandle module={module} moduleType={moduleType} moduleData={moduleData}></MenuHandle>}
                </div>*/}

                <div className="col-md-12">
                    {module && moduleType && selectedOption && <OptionHandle module={module} moduleType={moduleType} selectedOption={selectedOption}/> }
                </div>
            </div>
        </>
    );
}
