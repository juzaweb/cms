import Button, {ButtonProps} from "@/components/form/buttons/button";

export default function SuccessButton(props: ButtonProps) {
    return (
        <Button {...props} color={'success'} />
    );
}
