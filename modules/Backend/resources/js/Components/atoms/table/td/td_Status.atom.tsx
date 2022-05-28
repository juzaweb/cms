import React from 'react';
import { JW_TdStatusProps } from '.';

export const JW_TdStatus = ({
  className,
  color = 'green',
  children,
}: Partial<JW_TdStatusProps>) => {
  color = ' text-' + color + '-500 ';

  return (
    <div className={`flex flex-row items-center ${className} ${color}`}>
      <i className={`fas fa-circle mr-2 text-xs ${color} `}></i> {children}
    </div>
  );
};

export const JW_Status = ({
  className,
  color = 'green',
  children,
}: Partial<JW_TdStatusProps>) => {
  color = ' text-' + color + '-500 ';
  return (
    <div
      className={`inline-block text-center items-center ${className} ${color}`}
    >
      {children}
    </div>
  );
};
