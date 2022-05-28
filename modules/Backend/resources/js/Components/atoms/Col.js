import React from 'react';
import { JW_Field } from '@/components/atoms/Field'

export function JW_Col({options = {}, children = []}) {
    return (
        <div className={options.col ? 'col-md-'+ options.col : 'col'}>
            <JW_Field fields={children} />
        </div>
    );
}
