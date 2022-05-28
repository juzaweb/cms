import React from 'react';
import { JW_InputProps } from '.';
import cx from 'classnames';

export const JW_Input = ({label, name, options = {
    type: 'text'
}}: Partial<JW_InputProps>) => {
  return (
    <React.Fragment>
        <div className='form-group'>
            <label>{label}</label>
              <input
                  className={cx([
                      options.class,
                      'form-control',
                  ])}
                name={name}
                id={options.id}
                value={options.value}
                type={options.type || 'text'}
                placeholder={options.placeholder}
                onChange={options.onChange}
                checked={options.checked}
                disabled={options.disabled}
                autoComplete={options.autoComplete || 'off'}
              />
        </div>
    </React.Fragment>
  );
};
