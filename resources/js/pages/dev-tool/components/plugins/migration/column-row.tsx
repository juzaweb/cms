import {Column} from "@/pages/dev-tool/components/plugins/make-migration";

export default function ({column}: {column: Column}) {
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
                <select className={'form-control'} name={'foreign[]'}>
                    <option value="">----</option>
                    <option value="posts">posts</option>
                </select>
            </td>
        </tr>
    );
}
