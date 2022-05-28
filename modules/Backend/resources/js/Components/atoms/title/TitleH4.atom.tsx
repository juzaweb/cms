import React from 'react';
import cx from 'classnames';
import { TextProps, defaultPropsText } from './title.type';

export const JW_TitleH4 = (props: Partial<TextProps>) => {
  props = {
    ...defaultPropsText,
    ...props,
  };
  const {
    type,
    className,
    children,
    margin,
    color,
    fontSize,
    fontWeight,
    style,
    align,
  } = props as TextProps;
  return (
    <React.Fragment>
      <h4
        className={cx([
          `${type === 'light' ? 'text-white' : ''} font-bold`,
          className,
          {
            'text-center': align === 'center',
            'text-left': align === 'left',
            'text-right': align === 'right',
            'text-justify': align === 'justify',
          },
          {
            'mt-0': margin[0] === 0,
            'mt-1': margin[0] === 1,
            'mt-2': margin[0] === 2,
            'mt-3': margin[0] === 3,
            'mt-4': margin[0] === 4,
            'mt-5': margin[0] === 5,
            'mt-6': margin[0] === 6,
            'mt-8': margin[0] === 7,
            'mt-10': margin[0] === 8,
            'mt-12': margin[0] === 9,
            'mt-16': margin[0] === 10,
            'mt-20': margin[0] === 11,
            'mt-24': margin[0] === 12,
            'mt-32': margin[0] === 13,
            'mt-40': margin[0] === 14,
            'mt-48': margin[0] === 15,
            'mt-56': margin[0] === 16,
            'mt-64': margin[0] === 17,
            'mt-auto': margin[0] === 18,
          },
          {
            'mr-0': margin[1] === 0,
            'mr-1': margin[1] === 1,
            'mr-2': margin[1] === 2,
            'mr-3': margin[1] === 3,
            'mr-4': margin[1] === 4,
            'mr-5': margin[1] === 5,
            'mr-6': margin[1] === 6,
            'mr-8': margin[1] === 7,
            'mr-10': margin[1] === 8,
            'mr-12': margin[1] === 9,
            'mr-16': margin[1] === 10,
            'mr-20': margin[1] === 11,
            'mr-24': margin[1] === 12,
            'mr-32': margin[1] === 13,
            'mr-40': margin[1] === 14,
            'mr-48': margin[1] === 15,
            'mr-56': margin[1] === 16,
            'mr-64': margin[1] === 17,
            'mr-auto': margin[1] === 18,
          },
          {
            'mb-0': margin[2] === 0,
            'mb-1': margin[2] === 1,
            'mb-2': margin[2] === 2,
            'mb-3': margin[2] === 3,
            'mb-4': margin[2] === 4,
            'mb-5': margin[2] === 5,
            'mb-6': margin[2] === 6,
            'mb-8': margin[2] === 7,
            'mb-10': margin[2] === 8,
            'mb-12': margin[2] === 9,
            'mb-16': margin[2] === 10,
            'mb-20': margin[2] === 11,
            'mb-24': margin[2] === 12,
            'mb-32': margin[2] === 13,
            'mb-40': margin[2] === 14,
            'mb-48': margin[2] === 15,
            'mb-56': margin[2] === 16,
            'mb-64': margin[2] === 17,
            'mb-auto': margin[2] === 18,
          },
          {
            'ml-0': margin[3] === 0,
            'ml-1': margin[3] === 1,
            'ml-2': margin[3] === 2,
            'ml-3': margin[3] === 3,
            'ml-4': margin[3] === 4,
            'ml-5': margin[3] === 5,
            'ml-6': margin[3] === 6,
            'ml-8': margin[3] === 7,
            'ml-10': margin[3] === 8,
            'ml-12': margin[3] === 9,
            'ml-16': margin[3] === 10,
            'ml-20': margin[3] === 11,
            'ml-24': margin[3] === 12,
            'ml-32': margin[3] === 13,
            'ml-40': margin[3] === 14,
            'ml-48': margin[3] === 15,
            'ml-56': margin[3] === 16,
            'ml-64': margin[3] === 17,
            'ml-auto': margin[3] === 18,
          },
          {
            'text-xs': fontSize === 1,
            'text-sm': fontSize === 2,
            'text-base': fontSize === 3,
            'text-lg': fontSize === 4,
            'text-xl': fontSize === 5,
            'text-2xl': fontSize === 6,
            'text-3xl': fontSize === 7,
            'text-4xl': fontSize === 8,
            'text-5xl': fontSize === 9,
            'text-6xl': fontSize >= 10,
          },
          {
            'font-hairline': fontWeight === 1,
            'font-thin': fontWeight === 2,
            'font-light': fontWeight === 3,
            'font-normal': fontWeight === 4,
            'font-medium': fontWeight === 5,
            'font-semibold': fontWeight === 6,
            'font-bold': fontWeight === 7,
            'font-extrabold': fontWeight === 8,
            'font-black': fontWeight === 9,
          },
        ])}
        style={{
          ...style,
          ...{
            color: `rgba(${Object.values(color as any)})`,
          },
        }}
      >
        {children}
      </h4>
    </React.Fragment>
  );
};
