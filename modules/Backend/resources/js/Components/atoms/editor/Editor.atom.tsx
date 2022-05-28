import React, {useRef} from 'react';
import { JW_EditorProps } from '.';
import { Editor } from '@tinymce/tinymce-react';

export const JW_Editor = ({label, name, options = {}}: Partial<JW_EditorProps>) => {
    const editorRef = useRef(null);

    return (
        <React.Fragment>
            <div className='form-group'>
                <label>{label}</label>

                <Editor
                    onInit={(evt, editor) => editorRef.current = editor}
                    initialValue={options.value}
                    textareaName={name}
                    init={{
                        height: 400,
                        plugins: [
                            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                            "searchreplace wordcount visualblocks visualchars code fullscreen",
                            "insertdatetime media nonbreaking save table directionality",
                            "emoticons template paste textpattern bbcode"
                        ],
                        menu: {
                            file: { title: 'File', items: 'newdocument restoredraft | preview | print ' },
                            edit: { title: 'Edit', items: 'undo redo | cut copy paste | selectall | searchreplace' },
                            view: { title: 'View', items: 'code | visualaid visualchars visualblocks | spellchecker | preview fullscreen' },
                            insert: { title: 'Insert', items: 'image link media template codesample inserttable | charmap emoticons hr | pagebreak nonbreaking anchor toc | insertdatetime' },
                            format: { title: 'Format', items: 'bold italic underline strikethrough superscript subscript codeformat | formats blockformats fontformats fontsizes align lineheight | forecolor backcolor | removeformat' },
                            tools: { title: 'Tools', items: 'spellchecker spellcheckerlanguage | code wordcount' },
                            table: { title: 'Table', items: 'inserttable | cell row column | tableprops deletetable' },
                        },
                        toolbar: [
                            {
                                name: 'new', items: [ 'newdocument' ]
                            },
                            {
                                name: 'history', items: [ 'undo', 'redo' ]
                            },
                            {
                                name: 'styles', items: [ 'styleselect' ]
                            },
                            {
                                name: 'formatting', items: [ 'bold', 'italic']
                            },
                            {
                                name: 'alignment', items: [ 'alignleft', 'aligncenter', 'alignright', 'alignjustify' ]
                            },
                            {
                                name: 'indentation', items: [ 'outdent', 'indent' ]
                            },
                            {
                                name: 'media', items: [ 'link', 'image', 'media' ]
                            },
                            {
                                name: 'view', items: [ 'code', 'preview', 'fullscreen' ]
                            }
                        ],
                        file_picker_callback : function(callback, value, meta) {
                            let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                            let y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;
                            let cmsURL = '/admin-cp/file-manager?editor=' + meta.fieldname;

                            if (meta.filetype == 'image') {
                                cmsURL = cmsURL + "&type=image";
                            } else {
                                cmsURL = cmsURL + "&type=file";
                            }

                            this.windowManager.openUrl({
                                url: cmsURL,
                                title: 'File Manager',
                                width: x * 0.8,
                                height: y * 0.8,
                                onMessage: (api, message) => {
                                    callback(message.content);
                                }
                            });
                        }
                    }}
                />
            </div>
        </React.Fragment>
    );
};
