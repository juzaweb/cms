export interface ButtonProps {
    id?: string
    type?: 'button' | 'submit' | 'reset'
    label?: string
    class?: string
}

export default function Button(props: ButtonProps) {
    return (
        <button
            type={props.type || 'button'}
            id={props.id}
            className={`btn ${props.class || 'btn-primary'}`}
        >
            {props.label}
        </button>
    );
}
