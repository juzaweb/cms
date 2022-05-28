export type JW_InputProps = {
  type: 'text' | 'number' | 'password' | 'email' | 'checkbox' | 'submit';
  inputName: string;
  idInput: string;
  value: any;
  placeholder: string;
  onChange: any;
  className: string;
  checked: boolean;
  disabled: boolean;
};
