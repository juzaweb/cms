import React from 'react';
import cx from 'classnames';
import { ButtonMTProps, ButtonTypes } from './Button.type';

const defaultProps = {
  type: ButtonTypes.PRIMARY,
};

export const LFM_Button = (props: Partial<ButtonMTProps>) => {
  props = {
    ...defaultProps,
    ...props,
  };
  const a = [1, 2, 3];
  const { type, className, children, style } = props;
  //   let colorTheme = '';
  //   if (type === ButtonTypes.PRIMARY) colorTheme = 'bg-blue-500 text-white';
  return (
    <>
      <button
        className={cx([
          className,
          'p-3 rounded',
          {
            'bg-blue-500 text-white hover:bg-blue-600':
              type === ButtonTypes.PRIMARY,
            'bg-yellow-500 text-white hover:bg-yellow-600':
              type === ButtonTypes.WARNING,
          },
        ])}
      >
        {children}
      </button>
    </>
  );
};
