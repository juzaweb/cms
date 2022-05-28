import React from 'react';
import { JW_ThHeaderProps } from '.';

export const JW_ThHeader = ({
  children,
  color = 'light',
  className = '',
}: Partial<JW_ThHeaderProps>) => {
  return (
    <React.Fragment>
      <th
        className={
          'px-3 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left ' +
          (color === 'light'
            ? 'bg-gray-100 text-gray-600 border-gray-200'
            : 'bg-blue-800 text-blue-300 border-blue-700') +
          ' ' +
          className
        }
      >
        {children}
      </th>
    </React.Fragment>
  );
};
