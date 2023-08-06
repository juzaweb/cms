import React from "react";

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

export default function Checkbox(props: CheckboxProps = {required: false, class: ''}) {
    return (
        <div className="form-group">
            <label className="jw__utils__control jw__utils__control__checkbox" htmlFor={props.id}>
                <input
                    type="checkbox"
                    name={props.name}
                    className={`form-control ${props.class || ''}`}
                    id={props.id}
                    value={props.value || '1'}
                    autoComplete="off"
                    defaultChecked={props.checked || false}
                    onChange={props.onChange}
                />

                <span className="jw__utils__control__indicator"></span>

                { props.label || props.name }
            </label>
        </div>
    );
}
