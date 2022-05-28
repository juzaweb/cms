import React from 'react';
import {JW_CardProps} from '.';
import cx from 'classnames';
import {JW_Field} from "../field";

export const JW_Card = ({options = {}, children = []}: Partial<JW_CardProps>) => {
    return (
        <React.Fragment>
            <div className={cx([
                options.class,
                'card',
            ])}>
                {
                    options.header_title ? '<div class=\'card-header\'>{options.header_title}</div>' : ''
                }

                <div className='card-body'>
                    <JW_Field fields={children}/>
                </div>
            </div>
        </React.Fragment>
    );
};
