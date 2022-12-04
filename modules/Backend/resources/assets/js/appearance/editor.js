let editor = null;

function loadFileEditor(file) {
    ajaxRequest(
        loadFileUrl + "?file={{ $file }}",
        {},
        {
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
            }
        }
    );
}

$(document).ready(function() {
    $('.treeview-animated').mdbTreeview();

    require.config({ paths: { vs: monacoFolder } });

    require(['vs/editor/editor.main'], function () {
        loadFileEditor(file)

        $('#save-change').on('click', function () {
            ajaxRequest(saveUrl, {
                content: editor.getValue(),
                file: file
            }, {
                callback: function (response) {
                    show_message(response);
                }
            });
        });
    });
});
