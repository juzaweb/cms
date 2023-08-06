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
    options?: Array<{ label: string; data: string }>;
}

export default function Select(props: SelectProps) {
    return (
        <div className="form-group">
            <label className="col-form-label" htmlFor={props.id}>
                {props.label || props.name}
                {props.required ? (
                    <abbr>*</abbr>
                ) : ''}
            </label>

            <select
                name={props.name}
                id={props.id}
                className={`form-control ${props.class || 'select2-default' }`}
                multiple={props.multiple}
            >
                {props.options?.map(({ label, data }) => (
                    <option value={data}>{label}</option>
                ))}
            </select>
        </div>
    );
}
