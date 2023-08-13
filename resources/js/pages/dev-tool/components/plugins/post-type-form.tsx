import Input from "@/components/form/inputs/input";
import Textarea from "@/components/form/inputs/textarea";
import Checkbox from "@/components/form/inputs/checkbox";
import Button from "@/components/form/buttons/button";
import {convert_to_label_field, convert_to_slug} from "@/helpers/functions";
import {useState} from "react";

export default function PostTypeForm({ buttonLoading }: { buttonLoading: boolean }) {
    const [label, setLabel] = useState('');

    const generateLabelByName = (e: any) => {
        // If the input label is not empty, return
        if (e.target.value === '') {
            return;
        }

        // Format name to be [a-z0-9\-]
        let name = convert_to_slug(e.target.value);
        let label = convert_to_label_field(name);

        // Set label to the input
        e.target.value = name;
        setLabel(label);
    }

    return (
        <div className={'row'}>
            <div className="col-md-9">
                <Input name="key" label={'Tag'} required={true} onBlur={generateLabelByName} />

                <Input name="label" label={'Label'} required={true} value={label} />

                <Textarea name="description" label={'Description'} rows={3} />

                <Button label={'Make Post Type'} type={'submit'} loading={buttonLoading}  />
            </div>

            <div className="col-md-3">
                <Checkbox name={'supports[]'} label={'Has Comments'} value={'comment'} />

                <Checkbox name={'supports[]'} label={'Has Category'} value={'category'} />

                <Checkbox name={'supports[]'} label={'Has Tag'} value={'tag'}/>

                <Input name="menu_position" label={'Menu Position'} type={'number'} value={'20'} />
            </div>
        </div>
    )
}
