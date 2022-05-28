import React from 'react';
import { JW_MoneyInputProps } from './MoneyInput.type';

export const JW_MoneyInput = ({
  className = '',
  value,
  currency,
  currencyClass = '',
  onChange,
  disabled = false,
}: JW_MoneyInputProps) => {
  return (
    <form
      className={`flex flex-row border-2 text-gray-500 bg-blue rounded text-base leading-6 focus:outline-none focus:ring ease-linear transition-all duration-150 ${className}`}
    >
      <input
        type="number"
        className="w-full px-3 py-2 focus:outline-none"
        value={value}
        onChange={(ev) => {
          onChange(ev.target.value);
        }}
        disabled={disabled}
      />
      <span className={`${currencyClass} px-3 py-2`}>{currency}</span>
    </form>
  );
};
