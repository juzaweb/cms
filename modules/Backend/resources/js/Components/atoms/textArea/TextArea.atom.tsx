import React from 'react';
import { JW_TextAreaProps } from '.';
import cx from "classnames";

export const JW_TextArea = ({label, name, options = {},}: Partial<JW_TextAreaProps>) => {
  return (
    <React.Fragment>
        <div className='form-group'>
            <label>{label}</label>
            <textarea
                className={cx([
                    options.class,
                    'form-control',
                ])}
                name={name}
                id={options.id}
                placeholder={options.placeholder}
                onChange={options.onChange}
                disabled={options.disabled}
            >{options.value}</textarea>
        </div>
    </React.Fragment>
  );
};
