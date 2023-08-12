export const InputFieldTypes: { [key: string]: string } = {
    'text': 'Text',
    'textarea': 'Textarea',
    'number': 'Number',
    //'select': 'Select',
    'checkbox': 'Checkbox',
    'image': 'Image',
    'images': 'Images',
}

export interface InputField {
    name: string
    type: string
    label: string
    value?: string
}
