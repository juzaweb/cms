export interface TextareaProps {
    name?: string;
    id?: string;
    label?: string;
    value?: string;
    class?: string;
    placeholder?: string;
    required?: boolean;
    rows?: number;
    description?: string;
}

const TextareaDefaults: TextareaProps = {
    required: false,
    rows: 5
}

export default function Textarea(props: TextareaProps) {
    return (
        <div className="form-group">
            <label className="col-form-label" htmlFor={props.id || props.name}>
                { props.label || props.name }
                {props.required ? (
                    <abbr>*</abbr>
                ): ''}
            </label>

            <textarea
                name={props.name}
                className={`form-control`+ (props.class ? ' '+props.class : '')}
                id={props.id}
                autoComplete="off"
                rows={props.rows}
                placeholder={props.placeholder}
                defaultValue={props.value}
            ></textarea>

            {props.description && (
                <small className="form-text text-muted">{props.description}</small>
            )}
        </div>
    );
}
