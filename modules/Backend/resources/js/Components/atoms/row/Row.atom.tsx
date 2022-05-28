import React from 'react';
import {JW_RowProps} from '.';
import cx from 'classnames';
import {JW_Field} from "../Field";

export const JW_Row = ({options = {}, children = []}: Partial<JW_RowProps>) => {
    return (
        <React.Fragment>
            <div className={cx([
                options.class,
                'row',
            ])}>
                <JW_Field fields={children} />
            </div>
        </React.Fragment>
    );
};
