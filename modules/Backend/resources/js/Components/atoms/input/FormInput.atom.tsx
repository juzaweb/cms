import React from 'react';
import cx from 'classnames';
import { JW_FormInputProps } from '.';

export const JW_FormInput = ({
  className = null,
  inputName,
  inputClass,
  rows,
  idInput,
  idLabel,
  inputValue,
  labelValue,
  placeholder,
  onChange,
  onBlur,
  isDisabled = false,
  color = 'light',
  shadow = true,
}: Partial<JW_FormInputProps>) => {
  const colorScheme = {
    label: color === 'light' ? 'text-gray-800' : 'text-white',
    input: color === 'light' ? 'bg-white' : 'bg-gray-200 placeholder-gray-500',
  };
  return (
    <div className="flex flex-wrap">
      <div className="w-full px-4">
        <div
          className={
            'relative w-full mb-3 text-gray-600' + ' ' + className || ''
          }
        >
          <label
            id={idLabel}
            className={
              'block text-gray-700 text-sm font-normal mb-2 ' +
              colorScheme.label
            }
            htmlFor={inputName}
          >
            {labelValue}
          </label>
          <textarea
            id={idInput}
            rows={rows || 1}
            name={inputName}
            value={inputValue}
            onChange={onChange}
            onBlur={onBlur}
            placeholder={placeholder}
            disabled={isDisabled}
            className={cx([
              `px-3 py-3 rounded text-sm border focus:outline-none focus:ring 
            w-full ease-linear transition-all duration-150 resize-none placeholder-gray-400  
            ${colorScheme.input} ${shadow && 'shadow'}`,
              inputClass,
            ])}
          />
        </div>
      </div>
    </div>
  );
};
