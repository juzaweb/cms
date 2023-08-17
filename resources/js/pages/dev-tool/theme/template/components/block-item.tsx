import Input from "@/components/form/inputs/input";
import Button from "@/components/form/buttons/button";
import {PageTempate} from "@/types/themes";
import {useState} from "react";
import {convert_to_label_field, convert_to_name_field} from "@/helpers/functions";

export default function BlockItem(
    {
        setting,
        index
    }: {
        setting: PageTempate,
        index: number
    }) {
    const [customBlocks, setCustomBlocks] = useState<Array<{ name: string, label: string }>>(setting.blocks || []);
    const defaultBlock: { name: string, label: string } = {name: '', label: ''};
    const [labels, setLabels] = useState<Array<string>>([]);

    const handleAddBlock = (e: any) => {
        e.preventDefault();

        setCustomBlocks([...customBlocks, defaultBlock]);
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

    return <>
        {customBlocks?.map((block, blockIndex) => (
            <div className="row" key={blockIndex}>
                <div className="col-md-5">
                    <Input
                        name={`settings[${index}][blocks][${blockIndex}][name]`}
                        label={'Block Name'}
                        value={block.name}
                        onBlur={(e: any) => generateLabelByName(e, blockIndex)}
                    />
                </div>

                <div className="col-md-6">
                    <Input
                        name={`settings[${index}][blocks][${blockIndex}][label]`}
                        label={'Block Label'}
                        value={labels[blockIndex] || block.label}
                    />
                </div>

                <div className="col-md-1">
                    <a
                        href={'#'}
                        className={'text-danger'}
                        style={{float: 'right'}}
                        onClick={(e) => {
                            e.preventDefault();
                            setCustomBlocks(customBlocks.filter((_, i) => i !== blockIndex));
                        }}
                    >
                        <i className={'fa fa-trash'}></i>
                    </a>
                </div>
            </div>
        ))}

        <Button class={'btn-sm'} label={'Add block'} onClick={handleAddBlock} />
    </>;
}
