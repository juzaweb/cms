import React from 'react';
import {JW_Input} from "@/components/atoms/Input";
import {JW_Textarea} from "@/components/atoms/Textarea";
import {JW_Row} from '@/components/atoms/Row';
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
                                    <JW_Row key={index} children={item.children}/>
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
                                    <JW_Textarea
                                        key={index}
                                        inputLabel={item.label}
                                        inputName={item.name}
                                    />
                                )
                            case 'editor':
                                return (
                                    <div>Case 2</div>
                                )
                        }
                    })()
                })
            }
        </>
    );
};
