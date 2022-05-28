import React from 'react';
import cx from 'classnames';
import { ProgressMTProps } from './Progress.type';

const defaultProps = {};

/**
 * Progress component
 * @param {string} classnames Danh sách tên class áp dụng cho Progress
 * @param {object} style Object custom style áp dụng cho Progress
 * @param {any} children Component, Text,... con của Progress
 *
 * @returns
 */

export const LFM_Progress = (props: Partial<ProgressMTProps>) => {
  props = {
    ...defaultProps,
    ...props,
  };

  const { className, style, children } = props;

  return (
    <div
      style={style}
      className={cx([
        className,
        `flex
        h-4
        overflow-hidden
        leading-none
        bg-gray-200
        rounded-xl`,
      ])}
    >
      {children}
    </div>
  );
};
