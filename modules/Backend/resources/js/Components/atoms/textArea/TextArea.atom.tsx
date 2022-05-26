import React from 'react';
import { JW_TextAreaProps } from '.';

export const JW_TextArea = ({
  className,
  value,
  onChange,
  row,
  col,
  placeholder,
  name,
}: Partial<JW_TextAreaProps>) => {
  return (
    <React.Fragment>
      <textarea
        className={className}
        value={value}
        onChange={onChange}
        rows={row}
        cols={col}
        placeholder={placeholder}
        name={name}
      ></textarea>
    </React.Fragment>
  );
};
