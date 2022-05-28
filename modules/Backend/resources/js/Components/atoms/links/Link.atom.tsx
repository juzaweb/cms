import React from 'react';
import { Link } from 'react-router-dom';
import { LinkProps } from '.';

export const JW_Link = ({
  children,
  className,
  href,
  title,
  id = null,
  action = null,
}: Partial<LinkProps>) => {
  return (
    <React.Fragment>
      <Link
        to={href}
        className={`${className}`}
        id={id}
        onClick={action}
        title={title}
      >
        {children}
      </Link>
    </React.Fragment>
  );
};
