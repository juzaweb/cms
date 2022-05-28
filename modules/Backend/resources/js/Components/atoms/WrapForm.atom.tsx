import React from 'react';
import cs from 'classnames';
import { margin } from '.';

type JW_WrapFormProps = {
  children: any;
  marginTop: margin;
  marginBottom: margin;
};

export const JW_WrapForm = ({
  children,
  marginTop,
  marginBottom,
}: Partial<JW_WrapFormProps>) => {
  return (
    <div
      className={cs([
        'flex flex-wrap',
        {
          'mt-0': marginTop === 0,
          'mt-1': marginTop === 1,
          'mt-2': marginTop === 2,
          'mt-3': marginTop === 3,
          'mt-4': marginTop === 4,
          'mt-5': marginTop === 5,
          'mt-6': marginTop === 6,
          'mt-8': marginTop === 8,
          'mt-10': marginTop === 10,
          'mt-12': marginTop === 12,
          'mt-16': marginTop === 16,
          'mt-20': marginTop === 20,
          'mt-24': marginTop === 24,
          'mt-32': marginTop === 32,
          'mt-40': marginTop === 40,
          'mt-48': marginTop === 48,
          'mt-56': marginTop === 56,
          'mt-64': marginTop === 64,
          'mt-auto': marginTop === 'auto',
        },
        {
          'mb-0': marginBottom === 0,
          'mb-1': marginBottom === 1,
          'mb-2': marginBottom === 2,
          'mb-3': marginBottom === 3,
          'mb-4': marginBottom === 4,
          'mb-5': marginBottom === 5,
          'mb-6': marginBottom === 6,
          'mb-8': marginBottom === 8,
          'mb-10': marginBottom === 10,
          'mb-12': marginBottom === 12,
          'mb-16': marginBottom === 16,
          'mb-20': marginBottom === 20,
          'mb-24': marginBottom === 24,
          'mb-32': marginBottom === 32,
          'mb-40': marginBottom === 40,
          'mb-48': marginBottom === 48,
          'mb-56': marginBottom === 56,
          'mb-64': marginBottom === 64,
          'mb-auto': marginBottom === 'auto',
        },
      ])}
    >
      {children}
    </div>
  );
};
