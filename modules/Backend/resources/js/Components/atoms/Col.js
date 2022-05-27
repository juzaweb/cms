import React from 'react';
import { JW_Field } from '@/components/atoms/Field'

export function JW_Col({children = []}) {
    return (
        <div className="col">
            <JW_Field fields={children} />
        </div>
    );
}
