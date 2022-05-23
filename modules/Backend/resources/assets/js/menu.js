$(document).ready(function () {
    var updateOutput = function(e) {
        var list = e.length ? e : $(e.target);
        if (window.JSON) {
            $('#items-output').val(window.JSON.stringify(list.nestable('serialize')));
        } else {
            alert('JSON browser support required for this application.');
        }
    };

    $('#jw-menu-builder').nestable({
        noDragClass: 'dd-nodrag',
    }).on('change', updateOutput);

    updateOutput($('#jw-menu-builder'));

    $('#menu-container').on('submit', '.form-menu-block', function(event) {
        if (event.isDefaultPrevented()) {
            return false;
        }

        event.preventDefault();
        var form = $(this);
        var formData = new FormData(form[0]);
        var btnsubmit = form.find("button[type=submit]");
        var currentIcon = btnsubmit.find('i').attr('class');

        btnsubmit.find('i').attr('class', 'fa fa-spinner fa-spin');
        btnsubmit.prop("disabled", true);

        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            dataType: 'json',
            data: formData,
            cache:false,
            contentType: false,
            processData: false
        }).done(function(response) {

            btnsubmit.find('i').attr('class', currentIcon);
            btnsubmit.prop("disabled", false);

            if (response.status === false) {
                show_message(response);
                return false;
            }

            let items = response.data.items;
            if (items.length > 0) {
                $('#jw-menu-builder .dd-empty').remove();

                $.each(items, function (index, item) {
                    $('#jw-menu-builder .dd-list:first').append(item);
                });
            }

            updateOutput($('#jw-menu-builder'));
            form.find('.reset-after-add').val('');

            return false;
        }).fail(function(response) {
            btnsubmit.find('i').attr('class', currentIcon);
            btnsubmit.prop("disabled", false);

            show_message(response);
            return false;
        });
    });

    $('#menu-container').on('click', '.btn-add-menu', function () {
        let eForm = $('.form-add-menu');
        if (eForm.is(':hidden')) {
            eForm.show('slow');
        } else {
            eForm.hide('slow');
        }
    });

    $('#menu-container').on('change', '.form-select-menu .load-menu', function () {
        let id = $(this).val();
        if (id) {
            window.location = juzaweb.adminUrl + "/menus/" + id;
        }
    });

    $('#menu-container').on('click', '.card-menu-show', function () {
        let cardBody = $(this).closest('.card-menu-items').find('.card-body');
        if (cardBody.is(':hidden')) {
            $('.card-menu-items').find('.card-body').slideUp('slow');
            $('.card-menu-items').find('.card-header').removeClass('bg-light');
            $(this).closest('.card-menu-items').find('.card-header').addClass('bg-light');
            cardBody.slideDown('slow');
        } else {
            cardBody.slideUp('slow');
            $(this).closest('.card-menu-items').find('.card-header').removeClass('bg-light');
        }
    });

    $('#menu-container').on('click', '.show-menu-edit', function (e) {
        let formEdit = $(this).closest('.dd-item').find('.form-item-edit').first();
        if (formEdit.is(':hidden')) {
            formEdit.slideDown('slow');
        } else {
            formEdit.slideUp('slow');
        }
    });

    $('#menu-container').on('click', '.delete-menu', function (e) {
        let id = $(this).data('id');

        confirm_message(
            juzaweb.lang.remove_question.replace(':name', juzaweb.lang.menu),
            function (result) {
                if (result) {
                    ajaxRequest(
                        juzaweb.adminUrl + "/menus/" + id,
                        {},
                        {
                            'method': 'DELETE',
                            'callback': function (response) {
                                show_message(response);
                                window.location = juzaweb.adminUrl + "/menus";
                            }
                        }
                    );
                }
            }
        );
    });

    $('#menu-container').on('change', '.menu-data', function () {
        let name = $(this).data('name');
        let val = $(this).val();

        $(this).closest('li').data(name, val);
        updateOutput($('#jw-menu-builder'));

        if ($(this).hasClass('change-label')) {
            $(this).closest('li').find('.dd-handle span:first').text(val);
        }
    });

    $('#menu-container').on('click', '.delete-menu-item', function () {
        $(this).closest('li').remove();
        updateOutput($('#jw-menu-builder'));
    });

    $('#menu-container').on('click', '.close-menu-item', function () {
        let formEdit = $(this).closest('.dd-item').find('.form-item-edit').first();
        if (formEdit.is(':hidden')) {
            formEdit.slideDown('slow');
        } else {
            formEdit.slideUp('slow');
        }
    });

    $('#menu-container').on('change', '.select-all-checkbox', function () {
        let select = $(this).data('select');
        let checked = $(this).is(':checked');
        $(this).closest('.tab-pane').find('.' + select).prop('checked', checked);
    });

    $('#menu-container').on('keyup', '.menu-box-post-type-search', function () {
        let search = $(this).val();
        let key = $(this).data('key');
        let postType = $(this).data('post_type');
        let resultElement = $(this)
            .closest('.tab-pane')
            .find('.box-tab-search-result');
        resultElement.html('');

        if (search.length <= 0) {
            return false;
        }

        ajaxRequest(juzaweb.adminUrl +'/load-data/loadPostType', {
            search: search,
            per_page: 5,
            post_type: postType
        }, {
            method: 'GET',
            callback: function (response) {
                let temps = '';
                $.each(response.results, function (index, item) {
                    temps += `<div class="form-check mt-1">
                        <label class="form-check-label">
                            <input class="form-check-input select-all-search-${key}" type="checkbox" name="items[]" value="${item.id}">
                            ${item.text}
                        </label>
                    </div>`;
                });

                resultElement.html(temps);

                return false;
            }
        });

        return false;
    });

    $('#menu-container').on('keyup', '.menu-box-taxonomy-search', function () {
        let search = $(this).val();
        let key = $(this).data('key');
        let taxonomy = $(this).data('taxonomy');
        let resultElement = $(this)
            .closest('.tab-pane')
            .find('.box-tab-search-result');
        resultElement.html('');

        if (search.length <= 0) {
            return false;
        }

        ajaxRequest(juzaweb.adminUrl +'/load-data/loadTaxonomies', {
            search: search,
            per_page: 5,
            taxonomy: taxonomy
        }, {
            method: 'GET',
            callback: function (response) {
                let temps = '';
                $.each(response.results, function (index, item) {
                    temps += `<div class="form-check mt-1">
                        <label class="form-check-label">
                            <input class="form-check-input select-all-search-${key}" type="checkbox" name="items[]" value="${item.id}">
                            ${item.text}
                        </label>
                    </div>`;
                });

                resultElement.html(temps);

                return false;
            }
        });

        return false;
    });
});
