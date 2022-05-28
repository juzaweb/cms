import React, {useEffect} from 'react';
import { JW_EditorProps } from '.';
import cx from 'classnames';
import tinymce from 'tinymce/tinymce';

import "tinymce/themes/modern";
import "tinymce/plugins/paste";
import "tinymce/plugins/link";
import "tinymce/plugins/hr";
import "tinymce/plugins/advlist";
import "tinymce/plugins/autolink";
import "tinymce/plugins/lists";
import "tinymce/plugins/link";
import "tinymce/plugins/image";
import "tinymce/plugins/charmap";
import "tinymce/plugins/preview";
import "tinymce/plugins/anchor";
import "tinymce/plugins/pagebreak";
import "tinymce/plugins/searchreplace";
import "tinymce/plugins/wordcount";
import "tinymce/plugins/visualblocks";
import "tinymce/plugins/visualchars";
import "tinymce/plugins/code";
import "tinymce/plugins/fullscreen";
import "tinymce/plugins/insertdatetime";
import "tinymce/plugins/media";
import "tinymce/plugins/nonbreaking";
import "tinymce/plugins/save";
import "tinymce/plugins/table";
import "tinymce/plugins/directionality";
import "tinymce/plugins/emoticons";
import "tinymce/plugins/template";
import "tinymce/plugins/paste";
import "tinymce/plugins/textpattern";
import "tinymce/plugins/bbcode";

import 'tinymce/skins/lightgray/skin.min.css';
import 'tinymce/skins/lightgray/content.min.css'

export const JW_Editor = ({label, name, options = {}}: Partial<JW_EditorProps>) => {
    const inputId = options.id || 'content-';

    useEffect(() => {
        tinymce.init({
            selector: '#'+inputId,
            height: 400,
            plugins: [
                "advlist autolink lists link image charmap preview hr anchor pagebreak",
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
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;
                var cmsURL = '/admin-cp/file-manager?editor=' + meta.fieldname;

                if (meta.filetype == 'image') {
                    cmsURL = cmsURL + "&type=image";
                } else {
                    cmsURL = cmsURL + "&type=file";
                }

                tinymce.activeEditor.windowManager.openUrl({
                    url: cmsURL,
                    title: 'File Manager',
                    width: x * 0.8,
                    height: y * 0.8,
                    onMessage: (api, message) => {
                        callback(message.content);
                    }
                });
            }
        });
    }, [])

    return (
        <React.Fragment>
            <div className='form-group'>
                <label>{label}</label>
                <textarea
                    className={cx([
                        options.class,
                        'form-control',
                    ])}
                    name={name}
                    id={inputId}
                    placeholder={options.placeholder}
                    onChange={options.onChange}
                    disabled={options.disabled}
                >{options.value}</textarea>
            </div>
        </React.Fragment>
    );
};
