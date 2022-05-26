import React from 'react';
import { JW_TdLabelProps } from '.';

export const JW_TdLabel = ({
  className = '',
  theme = 'light',
  children,
}: Partial<JW_TdLabelProps>) => {
  return (
    <span
      className={
        +(theme === 'light' ? 'text-gray-700' : 'text-white') +
        (' ' + className)
      }
    >
      {children}
    </span>
  );
};
