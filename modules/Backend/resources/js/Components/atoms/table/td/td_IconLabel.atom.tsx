import React from 'react';
import { JW_TdIconLabelProps } from '.';

export const JW_TdIconLabel = ({
  className,
  theme,
  text,
  iconPath,
}: Partial<JW_TdIconLabelProps>) => {
  return (
    <React.Fragment>
      <div className="flex items-center">
        <img
          src={iconPath}
          className="h-12 w-12 bg-white rounded-full border"
          alt="..."
        ></img>{' '}
        <span
          className={
            'ml-3 font-bold ' +
            (theme === 'light' ? 'text-gray-700' : 'text-white') +
            ' ' +
            className
          }
        >
          {text}
        </span>
      </div>
    </React.Fragment>
  );
};
