export interface InputProps {
    name?: string;
    id?: string;
    label?: string;
    type?: string;
    value?: string;
    class?: string;
    placeholder?: string;
    required?: boolean;
}

export default function Input(props: InputProps = {type: 'text', required: false, class: ''}) {
    return (
        <div className="form-group">
            <label className="col-form-label" htmlFor={props.id}>
                { props.label || props.name }
                {props.required ? (
                    <abbr>*</abbr>
                ): ''}
            </label>

            <input
                type={props.type}
                name={props.name}
                className={`form-control ${props.class}`}
                id={props.id}
                value={props.value}
                autoComplete="off"
                placeholder={props.placeholder} />
        </div>
    );
}
