import React from 'react';
import cx from 'classnames';
import { JW_LabelProps } from '.';

export const JW_Label = ({
  children,
  className,
  htmlFor,
}: Partial<JW_LabelProps>) => {
  return (
    <React.Fragment>
      <label
        className={cx([
          'block uppercase text-gray-700 text-xs font-bold mb-2',
          className,
        ])}
        htmlFor={htmlFor}
      >
        {children}
      </label>
    </React.Fragment>
  );
};
