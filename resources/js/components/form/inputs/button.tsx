export interface ButtonProps {
    name?: string;
    id?: string;
    type?: string;
    label?: string;
    class?: string;
}

export default function Button (props: ButtonProps = {class: ''}) {
    return (
        <button className="btn btn-primary" type={props.type || 'button'}>{props.label}</button>
    )
}
