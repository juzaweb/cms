import React from 'react';
import cx from 'classnames';

export const JW_Textarea = ({inputLabel, inputName, inputOptions = {}}) => {
    return (
        <>
            <div className='form-group'>
                <label>{inputLabel}</label>
                <textarea
                    className={cx([
                        inputOptions.class,
                        'form-control',
                    ])}
                    name={inputName}
                    id={inputOptions.id}
                    placeholder={inputOptions.placeholder}
                    onChange={inputOptions.onChange}
                    disabled={inputOptions.disabled}
                >{inputOptions.value}</textarea>
            </div>
        </>
    );
};
