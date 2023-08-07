import {Column} from "@/pages/dev-tool/components/plugins/make-migration";
import Select from "react-select";
import {useEffect} from "react";

const options = [
    { value: '', label: '----' },
    { value: 'posts', label: 'Posts' },
    { value: 'pages', label: 'Pages' }
]

export default function ({column}: {column: Column}) {
    // useEffect(() => {
    //
    // }, []);

    return (
        <tr>
            <td>
                <input
                    type="text"
                    className={'form-control'}
                    name={'column[]'}
                    defaultValue={column.name}
                />
            </td>
            <td>
                <select className={'form-control'} name={'data_type[]'}>
                    <option value="string">string</option>
                    <option value="integer">integer</option>
                    <option value="text">text</option>
                    <option value="longText">longText</option>
                    <option value="tinyInteger">tinyInteger</option>
                    <option value="smallInteger">smallInteger</option>
                    <option value="bigIncrements">bigIncrements</option>
                </select>
            </td>
            <td className={'text-center'}>
                <input type="checkbox" className={''} name={'nullable[]'} value={'1'}/>
            </td>
            <td className={'text-center'}>
                <input type="checkbox" className={''} name={'index[]'} value={'1'}/>
            </td>
            <td>
                <Select name={'foreign[]'} options={options}></Select>
            </td>
        </tr>
    );
}
