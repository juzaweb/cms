import React from 'react';
import { JW_TRType } from '.';

export const JW_TR = ({ children, ...props }: Partial<JW_TRType>) => {
  return (
    <React.Fragment>
      <tr {...props}>{children}</tr>
    </React.Fragment>
  );
};
