import React from 'react';
import { JW_TdProps } from './td.type';

export const JW_Td = ({
  className,
  colSpan = 1,
  children,
}: Partial<JW_TdProps>) => {
  return (
    <td
      className={`border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs p-2 ${className}`}
      colSpan={colSpan}
    >
      {children}
    </td>
  );
};
