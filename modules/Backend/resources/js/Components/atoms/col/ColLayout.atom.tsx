import React from 'react';
import cx from 'classnames';

type JW_ColLayoutProps = {
  children: any;
  col: any;
  className?: string;
  color: string;
};

export const JW_ColLayout = ({
  children,
  col,
  className,
}: Partial<JW_ColLayoutProps>) => {
  const column = () => {
    switch (col) {
      case 1:
        return 'lg:w-1/12';
      case 2:
        return 'lg:w-2/12';
      case 3:
        return 'lg:w-3/12';
      case 4:
        return 'lg:w-4/12';
      case 5:
        return 'lg:w-5/12';
      case 6:
        return 'lg:w-6/12';
      case 7:
        return 'lg:w-7/12';
      case 8:
        return 'lg:w-8/12';
      case 9:
        return 'lg:w-9/12';
      case 10:
        return 'lg:w-10/12';
      case 11:
        return 'lg:w-11/12';
      default:
        return 'lg:w-12/12';
    }
  };
  return <div className={cx(['w-full', column(), className])}>{children}</div>;
};
