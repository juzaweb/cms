import React from 'react';
import { LinkProps } from '.';

export const JW_ALink = ({
  href = '#',
  className = '',
  action,
  children,
}: Partial<LinkProps>) => {
  return (
    <a
      href={href}
      className={className}
      onClick={action ? action : (e) => e.preventDefault()}
    >
      {children}
    </a>
  );
};
