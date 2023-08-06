import Input from "@/components/form/inputs/input";
import Checkbox from "@/components/form/inputs/checkbox";
import Button from "@/components/form/buttons/button";
import Select from "@/components/form/inputs/select";

export default function TaxonomyForm({buttonLoading}: { buttonLoading: boolean }) {
    return (
        <div className={'row'}>
            <div className="col-md-9">
                <Input name="key" label={'Tag'} required={true}/>

                <Input name="label" label={'Label'} required={true}/>

                <Select name={'post_types'} label={'Post Types'} required={true} multiple={true} options={
                    [
                        {
                            label: 'Posts',
                            data: 'posts',
                        },
                        {
                            label: 'Pages',
                            data: 'pages',
                        }
                    ]
                }/>

                <Button label={'Make Post Type'} type={'submit'} loading={buttonLoading}/>
            </div>

            <div className="col-md-3">

                <Checkbox name={'support[]'} label={'Has Thumbnail'} value={'thumbnail'}/>

                <Checkbox name={'show_in_menu'} label={'Show In Menu'} checked={true}/>

                <Input name="menu_position" label={'Menu Position'} type={'number'} value={'20'}/>
            </div>
        </div>
    )
}
