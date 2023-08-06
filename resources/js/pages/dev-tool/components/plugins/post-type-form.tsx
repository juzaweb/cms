import Input from "@/components/form/inputs/input";
import Textarea from "@/components/form/inputs/textarea";
import Checkbox from "@/components/form/inputs/checkbox";
import Button from "@/components/form/buttons/button";

export default function PostTypeForm({ buttonLoading }: { buttonLoading: boolean }) {
    return (
        <div className={'row'}>
            <div className="col-md-9">
                <Input name="key" label={'Tag'} required={true} />

                <Input name="label" label={'Label'} required={true} />

                <Textarea name="description" label={'Description'} rows={3} />

                <Button label={'Make Post Type'} type={'submit'} loading={buttonLoading}  />
            </div>

            <div className="col-md-3">
                <Checkbox name={'support[]'} label={'Has Comments'} value={'comment'} />

                <Checkbox name={'support[]'} label={'Has Category'} value={'category'} />

                <Checkbox name={'support[]'} label={'Has Tag'} value={'tag'}/>

                <Checkbox name={'show_in_menu'} label={'Show In Menu'} checked={true} />

                <Input name="menu_position" label={'Menu Position'} type={'number'} value={'20'} />
            </div>
        </div>
    )
}
