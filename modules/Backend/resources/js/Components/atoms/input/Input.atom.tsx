import React from 'react';
import { JW_InputProps } from '.';
import cx from 'classnames';

export const JW_Input = ({
  inputName,
  idInput,
  value,
  type,
  placeholder,
  onChange,
  className,
  checked,
  disabled = false,
}: Partial<JW_InputProps>) => {
  return (
    <React.Fragment>
      <input
        className={cx([
          className,
          'px-3 py-3 placeholder-gray-400 text-gray-500 bg-blue rounded text-sm shadow focus:outline-none focus:ring ease-linear transition-all duration-150',
        ])}
        name={inputName}
        id={idInput}
        value={value}
        type={type}
        placeholder={placeholder}
        onChange={onChange}
        checked={checked}
        disabled={disabled}
      />
    </React.Fragment>
  );
};
