import React, {useState} from "react";
import {indexOf} from "lodash";

export interface CheckboxProps {
    name?: string;
    id?: string;
    label?: string;
    class?: string;
    value?: string;
    checked?: boolean;
    required?: boolean;
    onChange?: (e: React.ChangeEvent<HTMLInputElement>) => void;
}

export default function Checkbox(props: CheckboxProps) {
    const [defaultValue, setDefaultValue] = useState<string|number|undefined>(props.value || (props.checked ? 1 : 0));
    const isBoolValue = indexOf([0, 1, '0', '1'], defaultValue) !== -1;

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        if (props.onChange) {
            props.onChange(e);
        }

        if (e.target.checked) {
            setDefaultValue(1);
        } else {
            setDefaultValue(0);
        }
    }

    return (
        <div className="form-group">
            <label className="jw__utils__control jw__utils__control__checkbox" htmlFor={props.id}>
                {isBoolValue && (
                    <input type="hidden" name={props.name} defaultValue={defaultValue} />
                )}

                <input
                    type="checkbox"
                    className={`form-control ${props.class || ''}`}
                    name={isBoolValue ? undefined : props.name}
                    id={props.id}
                    defaultValue={defaultValue}
                    autoComplete="off"
                    defaultChecked={props.checked || false}
                    onChange={handleChange}
                />

                <span className="jw__utils__control__indicator"></span>

                { props.label || props.name }
            </label>
        </div>
    );
}
