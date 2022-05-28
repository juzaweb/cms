import React from 'react';
import {
    JW_Input,
    JW_TextArea,
    JW_Editor,
    JW_Card,
    JW_Row
} from "@/components/atoms";

import {JW_Col} from "@/components/atoms/Col";
import {JW_Form} from "@/components/atoms/Form";

export const JW_Field = ({fields = []}) => {
    return (
        <>
            {
                fields.map((item, index) => {
                    return (() => {
                        switch (item.type) {
                            case 'row':
                                return (
                                    <JW_Row key={index} options={item.options} children={item.children}/>
                                )
                            case 'col':
                                return (
                                    <JW_Col key={index} options={item.options} children={item.children}/>
                                )
                            case 'text':
                                return (
                                    <JW_Input
                                        key={index}
                                        label={item.label}
                                        name={item.name}
                                        options={item.options}
                                    />
                                )
                            case 'form':
                                return (
                                    <JW_Form
                                        key={index}
                                        options={item.options}
                                        children={item.children}
                                    />
                                )
                            case 'textarea':
                                return (
                                    <JW_TextArea
                                        key={index}
                                        label={item.label}
                                        name={item.name}
                                    />
                                )
                            case 'card':
                                return (
                                    <JW_Card
                                        key={index}
                                        options={item.options}
                                        children={item.children}
                                    />
                                )
                            case 'editor':
                                return (
                                    <JW_Editor
                                        key={index}
                                        label={item.label}
                                        name={item.name}
                                        options={item.options}
                                    />
                                )
                        }
                    })()
                })
            }
        </>
    );
};
