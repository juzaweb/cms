export type JW_InputProps = {
    label: string;
    name: string;
    options: {
        type: 'text' | 'number' | 'password' | 'email' | 'checkbox' | 'submit';
        class?: string;
        id?: string;
        value?: string;
        placeholder?: string;
        onChange?: any;
        checked?: any;
        disabled?: boolean;
        autoComplete?: 'on' | 'off';
    };
};
