import React, { forwardRef } from 'react';
import Tippy from '@tippyjs/react';
// optional css import in all app if want to used

export const JW_Tooltips = ({ children, tips, ...attributes }) => {
  const JSX = forwardRef((props: any, ref: any) => {
    return <div ref={ref}>{children}</div>;
  });
  return (
    <Tippy content={tips} {...attributes}>
      <JSX />
    </Tippy>
  );
};
