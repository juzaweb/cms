import React from 'react';
import { JW_Field } from '@/components/atoms/Field'

export function JW_Card({options = {}, children = []}) {
    return (
        <div className='card'>
            {
                () => {
                    if (options.header_title) {
                        return (
                            <div className='card-header'>{options.header_title}</div>
                        )
                    }
                }
            }


            <div className='card-body'>
                <JW_Field fields={children} />
            </div>

        </div>
    );
}
