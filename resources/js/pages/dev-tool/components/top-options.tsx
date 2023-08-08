import {__, admin_url} from "@/helpers/functions";
import {useEffect, useState} from "react";
import axios from "axios";
import {Theme} from "@/types/themes";
import {Plugin} from "@/types/plugins";
import {ModuleData} from "@/pages/dev-tool/types/module";
import {router, usePage} from "@inertiajs/react";

export default function TopOptions({moduleSelected}: { moduleSelected?: string }) {
    const {url} = usePage().props;
    const [module, setModule] = useState<Theme|Plugin>();
    const [moduleType, setModuleType] = useState<string>();
    const [themes, setThemes] = useState<Array<Theme>>();
    const [plugins, setPlugins] = useState<Array<Plugin>>();
    const [moduleData, setModuleData] = useState<ModuleData>();
    const [selectedOption, setSelectedOption] = useState<string>('');

    useEffect(() => {
        axios.get(admin_url(`dev-tools/modules`)).then((res) => {
            setThemes(res.data.themes);
            setPlugins(res.data.plugins);
        });
    }, [url]);

    useEffect(() => {
        if (module && moduleType) {
            axios.get(admin_url(`dev-tools/module?module=${module.name}&type=${moduleType}`)).then((res) => {
                setModuleData(res.data);
            });
        }
    }, [module, moduleType]);

    const handleModuleChange = (e: any) => {
        let type = e.target.options[e.target.selectedIndex].getAttribute('data-type')?.toString() || '';
        let value = e.target.value;
        setSelectedOption('');
        localStorage.setItem('current_module', value);

        router.visit(
            admin_url(`dev-tools/${type}/${value}`),
            {replace: true}
        );

        // if (value) {
        //     setModuleType(type);
        //     if (type === 'plugins') {
        //         setModule(plugins.find((plugin: Plugin) => plugin.name === value));
        //     } else {
        //         setModule(themes.find((theme: Theme) => theme.name === value));
        //     }
        // } else {
        //     setModule(undefined);
        //     setModuleType(undefined);
        //     setModuleData(undefined);
        // }
    }

    return <div className={'row'}>
        <div className={'col-md-4'}>
            <select
                className={'form-control'}
                onChange={handleModuleChange}
                value={moduleSelected}
            >
                <option value="">{__('--- Select Module ---')}</option>
                <optgroup label={__('Themes')}></optgroup>
                {themes && themes.map((theme: any) => (
                    <option
                        value={theme.name}
                        key={theme.name}
                        data-type={'themes'}
                    >
                        {theme.title} ({theme.name})
                    </option>
                ))}
                <optgroup label={__('Plugins')}></optgroup>
                {plugins && plugins.map((plugin: any) => (
                    <option value={plugin.name}
                            key={plugin.name}
                            data-type={'plugins'}
                            className={'dropdown-item'}
                    >{plugin.extra?.juzaweb?.name || plugin.name} ({plugin.name})</option>
                ))}
            </select>
        </div>

        <div className="col-md-4">
            <select className={'form-control'} onChange={(e) => setSelectedOption(e.target.value)}>
                <option value="" selected={selectedOption == ''}>{__('--- Options ---')}</option>
                {moduleData && moduleData.configs.options.map((item) => (
                    <option
                        value={item.key}
                        key={item.key}
                        selected={selectedOption == item.key}
                    >
                        {__(item.label)}
                    </option>
                ))}
            </select>
        </div>
    </div>;
}
