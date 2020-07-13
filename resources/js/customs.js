$(document).on("turbolinks:load", function() {
    $('#lfm').filemanager('image', {prefix: '/admin-cp/filemanager'});

    $('.lfm').filemanager('image', {prefix: '/admin-cp/filemanager'});

    $('.lfm-file').filemanager('file', {prefix: '/admin-cp/filemanager'});

    var tag_item = '<span class="tag m-1">{name} <a href="javascript:void(0)" class="text-danger ml-1 remove-tag-item"><i class="fa fa-times-circle"></i></a>\n' +
        '  <input type="hidden" name="{field}[]" class="{field}-explode" value="{id}">\n' +
        '</span>';

    $('.add-new-category').on('click', function () {
        if ($('.form-add-category').is(":hidden")) {
            $('.form-add-category').show('slow');
        }
        else {
            $('.form-add-category').hide('slow');
        }
    });

    $('.add-new-tags').on('click', function () {
        if ($('.form-add-tags').is(":hidden")) {
            $('.form-add-tags').show('slow');
        }
        else {
            $('.form-add-tags').hide('slow');
        }
    });

    $('.select-tags').on('change', function () {
        let id = $(this).val();
        let name = $(this).find('option:selected').text();
        let item = replace_template(tag_item, {
            'name': name,
            'id': id,
            'field': 'tags',
        });

        $(".show-tags").append(item);
        $(this).val(null).trigger('change.select2');
    });

    $('.form-add-category').on('click', '.add-category', function () {
        let name = $("#categoryName").val();
        let category_item = '<li class="m-1" id="item-category-{id}">\n' +
            '  <div class="custom-control custom-checkbox">\n' +
            '    <input type="checkbox" name="categories[]" class="custom-control-input" id="category-{id}" value="{id}">\n' +
            '    <label class="custom-control-label" for="category-{id}">{name}</label>\n' +
            '  </div>\n' +
            '</li>';

        if (!name) {
            return false;
        }

        $.ajax({
            type: 'POST',
            url: '/admin-cp/post-categories/save',
            dataType: 'json',
            data: {
                'name': name,
                'status': 1,
                'addtype': 2,
            }
        }).done(function(data) {

            if (data.status === "error") {
                show_message(data.message, 'error');
                return false;
            }

            let item = replace_template(category_item, data);
            $(".show-categories ul").append(item);
            $("#categoryName").val('');

            return false;
        }).fail(function(data) {
            show_message(langs.data_error, 'error');
            return false;
        });
    });

    $('.add-new-types').on('click', function () {
        if ($('.form-add-types').is(":hidden")) {
            $('.form-add-types').show('slow');
        }
        else {
            $('.form-add-types').hide('slow');
        }
    });

    $('.form-add-types').on('click', '.add-type', function () {
        let name = $("#typesName").val();

        if (!name) {
            return false;
        }

        $.ajax({
            type: 'POST',
            url: '/admin-cp/types/save',
            dataType: 'json',
            data: {
                'name': name,
                'status': 1,
                'addtype': 2,
            }
        }).done(function(data) {

            if (data.status === "error") {
                show_message(data.message, 'error');
                return false;
            }

            var newOption = new Option(data.name, data.id, false, true);
            $("#select-types").append(newOption).trigger('change');
            $("#typesName").val('');

            return false;
        }).fail(function(data) {
            show_message(langs.data_error, 'error');
            return false;
        });
    });

    $('.form-add-tags').on('click', '.add-tags', function () {
        let name = $("#tagsName").val();

        if (!name) {
            return false;
        }

        $.ajax({
            type: 'POST',
            url: '/admin-cp/tags/save',
            dataType: 'json',
            data: {
                'name': name,
                'status': 1,
                'addtype': 2,
            }
        }).done(function(data) {

            if (data.status === "error") {
                show_message(data.message, 'error');
                return false;
            }

            data.field = 'tags';

            let item = replace_template(tag_item, data);
            $(".show-tags").append(item);
            $("#tagsName").val('');

            return false;
        }).fail(function(data) {
            show_message(langs.data_error, 'error');
            return false;
        });
    });

    /* genres */

    $('.add-new-genres').on('click', function () {
        if ($('.form-add-genres').is(":hidden")) {
            $('.form-add-genres').show('slow');
        }
        else {
            $('.form-add-genres').hide('slow');
        }
    });

    $('.select-genres').on('change', function () {
        let id = $(this).val();
        let name = $(this).find('option:selected').text();

        let item = replace_template(tag_item, {
            'name': name,
            'id': id,
            'field': 'genres',
        });

        $(".show-genres").append(item);
        $(this).val(null).trigger('change.select2');
    });

    $('.form-add-genres').on('click', '.add-genres', function () {
        let name = $("#genresName").val();

        if (!name) {
            return false;
        }

        $.ajax({
            type: 'POST',
            url: '/admin-cp/genres/save',
            dataType: 'json',
            data: {
                'name': name,
                'status': 1,
                'addtype': 2,
            }
        }).done(function(data) {

            if (data.status === "error") {
                show_message(data.message, 'error');
                return false;
            }

            data.field = 'genres';
            let item = replace_template(tag_item, data);
            $(".show-genres").append(item);
            $("#genresName").val('');

            return false;
        }).fail(function(data) {
            show_message(langs.data_error, 'error');
            return false;
        });
    });

    /* countries */
    $('.add-new-countries').on('click', function () {
        if ($('.form-add-countries').is(":hidden")) {
            $('.form-add-countries').show('slow');
        }
        else {
            $('.form-add-countries').hide('slow');
        }
    });

    $('.select-countries').on('change', function () {
        let id = $(this).val();
        let name = $(this).find('option:selected').text();

        let item = replace_template(tag_item, {
            'name': name,
            'id': id,
            'field': 'countries',
        });

        $(".show-countries").append(item);
        $(this).val(null).trigger('change.select2');
    });

    $('.form-add-countries').on('click', '.add-countries', function () {
        let name = $("#countriesName").val();

        if (!name) {
            return false;
        }

        $.ajax({
            type: 'POST',
            url: '/admin-cp/countries/save',
            dataType: 'json',
            data: {
                'name': name,
                'status': 1,
                'addtype': 2,
            }
        }).done(function(data) {

            if (data.status === "error") {
                show_message(data.message, 'error');
                return false;
            }

            data.field = 'countries';
            let item = replace_template(tag_item, data);
            $(".show-countries").append(item);
            $("#countriesName").val('');

            return false;
        }).fail(function(data) {
            show_message(langs.data_error, 'error');
            return false;
        });
    });

    /* actors */
    $('.add-new-actors').on('click', function () {
        if ($('.form-add-actors').is(":hidden")) {
            $('.form-add-actors').show('slow');
        }
        else {
            $('.form-add-actors').hide('slow');
        }
    });

    $('.select-actors').on('change', function () {
        let id = $(this).val();
        let name = $(this).find('option:selected').text();

        let item = replace_template(tag_item, {
            'name': name,
            'id': id,
            'field': 'actors',
        });

        $(".show-actors").append(item);
        $(this).val(null).trigger('change.select2');
    });

    $('.form-add-actors').on('click', '.add-actors', function () {
        let name = $("#actorsName").val();

        if (!name) {
            return false;
        }

        $.ajax({
            type: 'POST',
            url: '/admin-cp/stars/save',
            dataType: 'json',
            data: {
                'name': name,
                'status': 1,
                'addtype': 2,
                'type': 'actor',
                'field': 'actors',
            }
        }).done(function(data) {

            if (data.status === "error") {
                show_message(data.message, 'error');
                return false;
            }

            let item = replace_template(tag_item, data);
            $(".show-actors").append(item);
            $("#actorsName").val('');

            return false;
        }).fail(function(data) {
            show_message(langs.data_error, 'error');
            return false;
        });
    });

    /* directors */
    $('.add-new-directors').on('click', function () {
        if ($('.form-add-directors').is(":hidden")) {
            $('.form-add-directors').show('slow');
        }
        else {
            $('.form-add-directors').hide('slow');
        }
    });

    $('.select-directors').on('change', function () {
        let id = $(this).val();
        let name = $(this).find('option:selected').text();

        let item = replace_template(tag_item, {
            'name': name,
            'id': id,
            'field': 'directors',
        });

        $(".show-directors").append(item);
        $(this).val(null).trigger('change.select2');
    });

    $('.form-add-directors').on('click', '.add-directors', function () {
        let name = $("#directorsName").val();

        if (!name) {
            return false;
        }

        $.ajax({
            type: 'POST',
            url: '/admin-cp/stars/save',
            dataType: 'json',
            data: {
                'name': name,
                'status': 1,
                'addtype': 2,
                'type': 'director',
                'field': 'directors',
            }
        }).done(function(data) {

            if (data.status === "error") {
                show_message(data.message, 'error');
                return false;
            }

            let item = replace_template(tag_item, data);
            $(".show-directors").append(item);
            $("#directorsName").val('');

            return false;
        }).fail(function(data) {
            show_message(langs.data_error, 'error');
            return false;
        });
    });

    /* writers */
    $('.add-new-writers').on('click', function () {
        if ($('.form-add-writers').is(":hidden")) {
            $('.form-add-writers').show('slow');
        }
        else {
            $('.form-add-writers').hide('slow');
        }
    });

    $('.select-writers').on('change', function () {
        let id = $(this).val();
        let name = $(this).find('option:selected').text();

        let item = replace_template(tag_item, {
            'name': name,
            'id': id,
            'field': 'writers',
        });

        $(".show-writers").append(item);
        $(this).val(null).trigger('change.select2');
    });

    $('.form-add-writers').on('click', '.add-writers', function () {
        let name = $("#writersName").val();

        if (!name) {
            return false;
        }

        $.ajax({
            type: 'POST',
            url: '/admin-cp/stars/save',
            dataType: 'json',
            data: {
                'name': name,
                'status': 1,
                'addtype': 2,
                'type': 'writer',
                'field': 'writers',
            }
        }).done(function(data) {

            if (data.status === "error") {
                show_message(data.message, 'error');
                return false;
            }

            let item = replace_template(tag_item, data);
            $(".show-writers").append(item);
            $("#writersName").val('');

            return false;
        }).fail(function(data) {
            show_message(langs.data_error, 'error');
            return false;
        });
    });

    $(document).on('click', '.remove-tag-item', function () {
        $(this).closest('span.m-1').remove();
    });
});