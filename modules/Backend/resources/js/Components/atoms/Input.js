import React from 'react';
import cx from 'classnames';

export const JW_Input = ({inputLabel, inputName, inputOptions = {}}) => {
    return (
        <>
            <div className='form-group'>
                <label>{inputLabel}</label>
                <input
                    className={cx([
                        inputOptions.class,
                        'form-control',
                    ])}
                    name={inputName}
                    id={inputOptions.id}
                    value={inputOptions.value}
                    type={inputOptions.type || 'text'}
                    placeholder={inputOptions.placeholder}
                    onChange={inputOptions.onChange}
                    checked={inputOptions.checked}
                    disabled={inputOptions.disabled}
                />
            </div>
        </>
    );
};
