import React from 'react';
type JW_CheckboxProps = {
  className: string;
  checkBoxClass: string;
  value: boolean;
  children: any;
  onCheck: any;
};

export const JW_Checkbox = ({
  className = '',
  checkBoxClass = '',
  children = '',
  value,
  onCheck,
}: Partial<JW_CheckboxProps>) => {
  return (
    <label className={`custom-checkbox ${className}`}>
      {children}
      <input
        type="checkbox"
        checked={value}
        onChange={(ev) => {
          if (onCheck) onCheck(!value);
        }}
      />
      <span className={`${checkBoxClass}`}></span>
    </label>
  );
};
