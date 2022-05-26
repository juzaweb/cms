import React from 'react';
import cx from 'classnames';
import {
  LabelMTProps,
  LabelTypes,
  LabelSize,
  LabelColor,
  LabelFontWeight,
} from './Labels.type';
import { Type } from 'typescript';

const defaultProps = {
  type: LabelTypes.CIRCLE,
  size: LabelSize.SM,
  color: LabelColor.GRAY,
  weight: LabelFontWeight.NORMAl,
};

/**
 * Label component
 *
 * @param {LabelTypes} type Kiểu Label (CRICLE,ROUNDED,SQUARE,...) (default:CIRCLE)
 * @param {string} className  Danh sách tên class áp dụng cho Progress
 * @param {any}  children  Component, text,... con của Progress
 * @param {React.CSSProperties}  style  Any custom style áp dụng cho Progress.
 * @param {LabelSize}  size   Kích thước font chữ của Label (default: SM)
 * @param {LabelColor}  color  Kiểu và màu của Label (OUTLINE, DOT,...) (default: GRAY)
 * @param {LabelFontWeight}  weight  Font Weight của Label (default:NORMAL)
 *
 * @returns
 */

export const LFM_Label = (props: Partial<LabelMTProps>) => {
  props = {
    ...defaultProps,
    ...props,
  };

  const { type, className, children, style, size, color, weight } = props;

  return (
    <>
      <span
        style={style}
        className={cx([
          className,
          ' inline-flex justify-center items-center mr-2',
          {
            'p-0 m-0 rounded-full': type === LabelTypes.CIRCLE,
            'rounded-md': type === LabelTypes.ROUNDED,
            'rounded-none': type === LabelTypes.SQUARE,
            'rounded-md w-auto py-1 px-3 ': type === LabelTypes.INLINE,
            'rounded-fulll': type === LabelTypes.PILL,
          },

          {
            'bg-gray-200 text-gray-700': color === LabelColor.GRAY,
            'bg-green-500 text-white': color === LabelColor.SUCCESS,
            'bg-blue-500 text-white': color === LabelColor.PRIMARY,
            'bg-red-500 text-white': color === LabelColor.DANGER,
            'bg-yellow-500 text-white': color === LabelColor.WARNING,
            'bg-gray-900 text-white': color === LabelColor.DARK,
            'bg-purple-500 text-white': color === LabelColor.INFO,

            'bg-transparent text-green-500 border-green-500 border border-solid ':
              color === LabelColor.OUTLINE_SUCCESS,
            'bg-transparent text-blue-500 border-blue-500 border border-solid ':
              color === LabelColor.OUTLINE_PRIMARY,
            'bg-transparent text-red-500 border-red-500 border border-solid ':
              color === LabelColor.OUTLINE_DANGER,
            'bg-transparent text-yellow-500 border-yellow-500 border border-solid ':
              color === LabelColor.OUTLINE_WARNING,
            'bg-transparent text-gray-900 border-gray-900 border border-solid ':
              color === LabelColor.OUTLINE_DARK,
            'bg-transparent text-purple-500 border-purple-500 border border-solid ':
              color === LabelColor.OUTLINE_INFO,

            'text-green-500 bg-green-100': color === LabelColor.LIGHT_SUCCESS,
            'text-blue-500 bg-blue-100': color === LabelColor.LIGHT_PRIMARY,
            'text-red-500 bg-red-100': color === LabelColor.LIGHT_DANGER,
            'text-yellow-500 bg-yellow-100': color === LabelColor.LIGHT_WARNING,
            'text-gray-900 bg-gray-300': color === LabelColor.LIGHT_DARK,
            'text-purple-500 bg-purple-100': color === LabelColor.LIGHT_INFO,

            'bg-green-500 h-2.5': color === LabelColor.DOT_SUCCESS,
            'bg-blue-500 h-2.5': color === LabelColor.DOT_PRIMARY,
            'bg-red-500 h-2.5': color === LabelColor.DOT_DANGER,
            'bg-yellow-500 h-2.5': color === LabelColor.DOT_WARNING,
            'bg-gray-900 h-2.5': color === LabelColor.DOT_DARK,
            'bg-purple-500 h-2.5': color === LabelColor.DOT_INFO,
          },

          {
            'text-xs': size === LabelSize.SM,
            '': size === LabelSize.MD,
            'text-sm': size === LabelSize.LG,
            'text-base': size === LabelSize.XL,
          },

          {
            'font-extralight': weight === LabelFontWeight.LIGHTER,
            'font-light': weight === LabelFontWeight.LIGHT,
            'font-normal': weight === LabelFontWeight.NORMAl,
            'font-medium': weight === LabelFontWeight.BOLD,
            'font-semibold': weight === LabelFontWeight.BOLDER,
            'font-bold': weight === LabelFontWeight.BOLDEST,
          },
        ])}
      >
        {children}
      </span>
    </>
  );
};
