import React from 'react';
import { JW_InputGroupProps } from '.';

export const JW_InputGroup = (props: Partial<JW_InputGroupProps>) => {
  const { idInput, onChange, labelValue, placeholder, value, inputName } =
    props;
  return (
    <>
      <div>
        <label
          htmlFor={idInput}
          className="block text-sm leading-5 font-medium text-gray-700"
        >
          {labelValue}
        </label>
        <div className="mt-1 relative rounded-md shadow-sm">
          <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <span className="text-gray-500 sm:text-sm sm:leading-5">$</span>
          </div>
          <input
            id={idInput}
            className="form-input block w-full pl-7 pr-12 sm:text-sm sm:leading-5"
            name={inputName}
            value={value}
            onChange={onChange}
            placeholder={placeholder}
          />
          <div className="absolute inset-y-0 right-0 flex items-center">
            <select
              aria-label="Currency"
              className="form-select h-full py-0 pl-2 pr-7 border-transparent bg-transparent text-gray-500 sm:text-sm sm:leading-5"
            >
              <option>USD</option>
              <option>CAD</option>
              <option>EUR</option>
            </select>
          </div>
        </div>
      </div>
    </>
  );
};
