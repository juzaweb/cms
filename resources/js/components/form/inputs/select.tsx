import * as Select2 from 'react-select';

export interface SelectProps {
    name?: string;
    id?: string;
    label?: string;
    value?: string;
    class?: string;
    dataUrl?: string;
    required?: boolean;
    multiple?: boolean;
    disabled?: boolean;
    readonly?: boolean;
    options?: Array<{ label: string; value: string }>;
}

const SelectElement = Select2.default;

export default function Select(props: SelectProps) {
    let name = props.name ? (props.multiple ?  props.name + '[]' : props.name): undefined;

    return (
        <div className="form-group">
            <label className="col-form-label" htmlFor={props.id}>
                {props.label || props.name}
                {props.required ? (
                    <abbr>*</abbr>
                ) : ''}
            </label>

            <SelectElement
                name={name}
                id={props.id}
                className={props.class}
                isMulti={props.multiple}
                options={props.options}
            />
        </div>
    );
}
