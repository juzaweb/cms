import React from 'react';
import {JW_ColProps} from '.';
import cx from 'classnames';
import {JW_Field} from "../field";

export const JW_Col = ({options = {}, children = []}: Partial<JW_ColProps>) => {
    return (
        <React.Fragment>
            <div className={options.col ? 'col-md-'+ options.col : 'col'}>
                <JW_Field fields={children} />
            </div>
        </React.Fragment>
    );
};
