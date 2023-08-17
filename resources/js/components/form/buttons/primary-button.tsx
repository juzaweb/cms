import Button, {ButtonProps} from "@/components/form/buttons/button";

export default function PrimaryButton(props: ButtonProps) {
    return (
        <Button {...props} color={'primary'} />
    );
}
