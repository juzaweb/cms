import {__} from "@/helpers/functions";

export interface IndexProps {
    title: string
    themes: Array<any>
    plugins: Array<any>
}

export default function Index({ themes, plugins }: IndexProps) {

    return (
        <div className={'row'}>
            <div className={'col-md-4'}>
                <select name="" className={'form-control'}>
                    <option value="">{__('Select Module')}</option>
                    <optgroup label={__('Themes')}></optgroup>
                    {themes.map((theme: any) => (
                        <option value={theme.name} key={theme.name}>{theme.title}</option>
                    ))}
                    <optgroup label={__('Plugins')}></optgroup>
                    {plugins.map((plugin: any) => (
                        <option value={plugin.name} key={plugin.name}>{plugin.extra?.juzaweb?.name || plugin.name}</option>
                    ))}
                </select>
            </div>

            <div className="col-md-4">
                <select name="" className={'form-control'}>
                    <option value="">{__('Options')}</option>

                </select>
            </div>
        </div>
    );
}
