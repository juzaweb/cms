let editor = null;

function loadFileEditor(file) {
    $('.loading.editor').show();

    ajaxRequest(
        loadFileUrl + "?file="+ file,
        {},
        {
            method: 'GET',
            callback: function (data) {
                if (!editor) {
                    $('#editor').empty();
                    editor = monaco.editor.create(document.getElementById('editor'), {
                        model: null
                    });
                }

                let oldModel = editor.getModel();
                let newModel = monaco.editor.createModel(data.content, data.language);
                editor.setModel(newModel);

                if (oldModel) {
                    oldModel.dispose();
                }

                $('.loading.editor').fadeOut({ duration: 200 });
            }
        }
    );
}

$(document).ready(function() {
    $('.treeview-animated').mdbTreeview();

    $(document).on('change', '#change-theme', function () {
        window.location = themeEditUrl.replace('__THEME__', $(this).val());
        return false;
    });

    $(document).on('click', '.is-file', function () {
        loadFileEditor($(this).data('path'));
        return false;
    });

    require.config({ paths: { vs: monacoFolder } });

    require(['vs/editor/editor.main'], function () {
        loadFileEditor(file);

        $('#save-change').on('click', function () {
            ajaxRequest(saveUrl, {
                content: editor.getValue(),
                file: file,
            }, {
                callback: function (response) {
                    show_message(response);
                }
            });
        });
    });
});
