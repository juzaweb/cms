import React from 'react';

export const JW_From = ({ children, onSubmit }) => {
  return (
    <React.Fragment>
      <form onSubmit={onSubmit}>{children}</form>
    </React.Fragment>
  );
};
