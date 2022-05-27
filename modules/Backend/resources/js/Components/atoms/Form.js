import React from 'react';
import { JW_Field } from '@/components/atoms/Field'

export function JW_Form({action, children = []}) {
    return (
        <form action={action} className="jw-form">
            <JW_Field fields={children} />
        </form>
    );
}
