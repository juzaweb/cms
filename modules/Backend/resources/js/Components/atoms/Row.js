import React from 'react';
import { JW_Field } from '@/components/atoms/Field'

export function JW_Row({children = []}) {
    return (
        <div className="row">
            <JW_Field fields={children} />
        </div>
    );
}
