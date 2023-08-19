export interface ButtonProps {
    id?: string
    type?: 'button' | 'submit' | 'reset'
    label?: string
    class?: string
    loading?: boolean
    disabled?: boolean
    color?: string
    onClick?: (e: any) => void
}

export default function Button(props: ButtonProps) {
    return (
        <button
            type={props.type || 'button'}
            id={props.id}
            className={`btn btn-${props.color || 'primary'} ${props.class || ''}`}
            disabled={props.disabled || props.loading}
            onClick={props.onClick}
        >
            {props.loading ? (<>
                <i className="fa fa-spinner fa-spin"></i> {props.label}
            </>) : props.label}
        </button>
    );
}
