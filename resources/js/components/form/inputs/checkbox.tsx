export interface CheckboxProps {
    name?: string;
    id?: string;
    label?: string;
    class?: string;
    required?: boolean;
}

export default function Checkbox(props: CheckboxProps = {required: false, class: ''}) {
    return (
        <div className="form-group">
            <label className="jw__utils__control jw__utils__control__checkbox" htmlFor={props.id}>
                <input
                    type="checkbox"
                    name={props.name}
                    className={`form-control ${props.class}`}
                    id={props.id}
                    value="1"
                    autoComplete="off" />

                <span className="jw__utils__control__indicator"></span>

                { props.label || props.name }
            </label>
        </div>
    );
}
