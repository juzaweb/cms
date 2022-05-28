import React from 'react';
import { JW_Field } from '@/components/atoms/Field'

export function JW_Form({options = {}, children = []}) {
    return (
        <form action={options.action} className="jw-form">
            <JW_Field fields={children} />
        </form>
    );
}
