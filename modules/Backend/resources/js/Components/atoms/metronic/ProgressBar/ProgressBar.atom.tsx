import React from 'react';
import cx from 'classnames';
import { ProgressBarMTProps, ProgressBarTypes } from './ProgressBar.type';

const defaultProps = {
  valueNow: 0,
  valueMin: 0,
  valueMax: 100,
  type: ProgressBarTypes.PRIMARY,
  striped: false,
  animation: false,
};

/**
 * Progressbar component
 *
 * @param {ProgressBarTypes} type Kiểu màu của ProgressBar (default: PRIMARY)
 * @param {number} valueNow Giá trị hiện tại (default: 0)
 * @param {number} valueMin Giá trị thấp nhất (default: 0)
 * @param {number} valueMax Giá trị cao nhất (default: 100)
 * @param {boolean} striped Hiệu ứng sọc (default: false)
 * @param {boolean} animation Hoạt ảnh sọc di chuyển (default: false)
 * @param {string} className Danh sách tên class áp dụng cho Progress
 * @param {object} style Object custom style áp dụng cho Progress
 * @param {any} children Component, Text,... con của ProgressBar
 *
 * @returns
 */

export const LFM_ProgressBar = (props: Partial<ProgressBarMTProps>) => {
  props = {
    ...defaultProps,
    ...props,
  };

  const {
    valueNow,
    valueMin,
    valueMax,
    type,
    className,
    children,
    striped,
    animation,
    style,
  } = props;

  console.log(valueNow, valueMin === 0 ? 1 : valueMin, valueMax);
  const percent = (100 / (valueMax - valueMin)) * (valueNow - valueMin);
  console.log(percent);
  return (
    <div
      style={{ ...style, width: percent.toString() + '%' }}
      className={cx([
        className,
        'h-full flex justify-center items-center',
        {
          'bg-blue-500 text-white': type === ProgressBarTypes.PRIMARY,
          'bg-yellow-500 text-white': type === ProgressBarTypes.WARNING,
          'bg-red-500 text-white': type === ProgressBarTypes.DANGER,
          'bg-green-500 text-white': type === ProgressBarTypes.SUCCESS,
          'progress-bar-striped': striped === true,
          'progress-bar-striped progress-bar-animated': animation === true,
        },
      ])}
    >
      {children}
    </div>
  );
};
