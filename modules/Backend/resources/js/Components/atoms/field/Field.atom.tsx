import React from 'react';
import {JW_Row} from "../row";
import {JW_Col} from "../col";
import {JW_Input} from "../input";
import {JW_Form} from "../form";
import {JW_TextArea} from "../textArea";
import {JW_Card} from "../card";
import {JW_Editor} from "../editor";

export const JW_Field = ({fields = []}) => {
  return (
    <React.Fragment>
        {
            fields.map((item, index) => {
                return (() => {
                    switch (item.type) {
                        case 'row':
                            return (
                                <JW_Row
                                    key={index}
                                    options={item.options}
                                    children={item.children}
                                />
                            )
                        case 'col':
                            return (
                                <JW_Col
                                    key={index}
                                    options={item.options}
                                    children={item.children}
                                />
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
                                    options={item.options}
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
    </React.Fragment>
  );
};
