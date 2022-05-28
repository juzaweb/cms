import React from 'react';
import cx from 'classnames';

export const JW_Input = ({label, name, options = {}}) => {
    return (
        <>
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
        </>
    );
};
