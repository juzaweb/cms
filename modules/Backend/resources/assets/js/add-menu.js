$("#accordion").accordionjs();

const itemTemplate = document.getElementById('menu-item').innerHTML;
const updateOutput = function (e) {
    let list = e.length ? e : $(e.target),
        output = list.data('output');
    if (window.JSON) {
        output.val(window.JSON.stringify(list.nestable('serialize')));
    } else {
        output.val('JSON browser support required for this demo.');
    }
};

function buildItem(item) {
    let children = "";
    if (item.children) {
        children += "<ol class='dd-list'>";
        $.each(item.children, function (index, sub) {
            children += buildItem(sub);
        });
        children += "</ol>";
    }

    return replace_template(itemTemplate, {
        'id': item.id,
        'content': htmlspecialchars(item.content),
        'url': item.url,
        'new_tab': item.new_tab,
        'object_id': item.object_id,
        'object_type': item.object_type,
        'children': children,
    });
}

function buildMenu(dataJson) {
    let output = '';
    $.each(JSON.parse(dataJson), function (index, item) {
        output += buildItem(item);
    });
    return output;
}

const output = buildMenu(dataJson);
const nestable = $('#nestable');
const formMenu = $("#form-menu");

$('#dd-empty-placeholder').html(output);

nestable.nestable({
    group: 1,
    includeContent: true,
    scroll: true,
    emptyClass: false,
}).on('change', updateOutput);

updateOutput(nestable.data('output', $('#nestable-output')));

function getNewMenuId() {
    return $('.dd-item').length + 1;
}

$("#add-url").on('change', function () {
    let text = $(this).find('option:selected').text().trim();
    $('#add-title').val(text);
});

formMenu.on('click', '.remove-menu-item', function () {
    let id = $(this).closest('li').data('id');
    nestable.nestable('remove', id);
    updateOutput(nestable.data('output', $('#nestable-output')));
});

formMenu.on('click', '.edit-menu-item', function () {
    let item = $(this).closest('.dd-item');
    let id = item.data('id');
    let content = item.data('content');
    let url = item.data('url');
    let new_tab = item.data('new_tab');

    $("#id").val(id);
    $("#content").val(content);
    $("#url").val(url);

    if (new_tab == 1) {
        $('#new_tab').prop('checked', true);
    } else {
        $('#new_tab').prop('checked', false);
    }

    $("#modal-edit-menu").modal();
});

$("#modal-edit-menu").on('click', '.save-menu-item', function () {
    let id = $("#id").val();
    let item = $('#item-' + id);
    let content = $("#content").val();
    let url = $("#url").val();
    let new_tab = 0;

    if ($('#new_tab').is(':checked')) {
        new_tab = 1;
    }

    if (!content) {
        return false;
    }

    item.data('content', content);
    item.data('url', url);
    item.data('new_tab', new_tab);
    item.find('.dd-handle:first').text(htmlspecialchars(content));

    updateOutput($('#nestable').data('output', $('#nestable-output')));
    $("#modal-edit-menu").modal('hide');
});

$(".load-menu").on('change', function () {
    let id = $(this).val();
    window.location = juzaweb.adminUrl + "/menu/" + id;
});

$('#accordion').on('submit', '.add-menu-item', function () {
    let formData = $(this).serialize();
    let type = $(this).find('input[name=type]').val();
    let new_id = getNewMenuId();
    let new_tab = 0;
    let btn = $(this).find('button[type=submit]');
    let icon = btn.find('i').attr('class');

    btn.find('i').attr('class', 'fa fa-spinner fa-spin');
    btn.prop("disabled", true);

    if ($(this).find('input[name=new_tab]').is(':checked')) {
        new_tab = 1;
    }

    if (type !== "custom") {
        $.ajax({
            type: "POST",
            url: "/" + juzaweb.adminPrefix + "/menu/get-data",
            dataType: 'json',
            data: formData,
            success: function (result) {
                $.each(result, function (index, item) {
                    let html = replace_template(itemTemplate, {
                        'id': new_id,
                        'content': htmlspecialchars(item.name).trim(),
                        'url': item.url,
                        'new_tab': new_tab,
                        'object_id': item.object_id,
                        'object_type': type,
                        'children': "",
                    });

                    $('ol#dd-empty-placeholder').append(html);
                });

                updateOutput($('#nestable').data('output', $('#nestable-output')));
                btn.find('i').attr('class', icon);
                btn.prop("disabled", false);
            }
        });
    } else {
        let title = $(this).find('input[name=title]').val();
        let url = $(this).find('input[name=url]').val();

        if (!url) {
            url = $(this).find('select[name=url]').val();
        }

        if (!title) {
            show_message('Please enter title!', 'error');
            return false;
        }

        let html = replace_template(itemTemplate, {
            'id': new_id,
            'content': htmlspecialchars(title).trim(),
            'url': url,
            'new_tab': new_tab,
            'object_id': "",
            'object_type': type,
            'children': "",
        });

        $('ol#dd-empty-placeholder').append(html);

        updateOutput($('#nestable').data('output', $('#nestable-output')));
        btn.find('i').attr('class', icon);
        btn.prop("disabled", false);
    }
    return false;
});
