$(document).on("turbolinks:load", function() {

    $('.select2').select2({
        allowClear: true,
        dropdownAutoWidth: true,
        width: '100%',
        placeholder: function (params) {
            return {
                id: null,
                text: params.placeholder,
            }
        },
    });

    $('.select2-default').select2({
        dropdownAutoWidth: true,
        width: '100%',
    });

    $('.load-genres').select2({
        allowClear: true,
        width: '100%',
        placeholder: function (params) {
            return {
                id: null,
                text: params.placeholder,
            }
        },
        ajax: {
            method: 'GET',
            url: '/admin-cp/load-data/loadGenres',
            dataType: 'json',
            data: function (params) {
                let explodes = $(this).data('explodes') ? $(this).data('explodes') : null;
                if (explodes) {
                    explodes = $("." + explodes).map(function () {return $(this).val();}).get();
                }

                var query = {
                    search: $.trim(params.term),
                    page: params.page,
                    explodes: explodes,
                };

                return query;
            }
        },
    });

    $('.load-countries').select2({
        allowClear: true,
        width: '100%',
        placeholder: function (params) {
            return {
                id: null,
                text: params.placeholder,
            }
        },
        ajax: {
            method: 'GET',
            url: '/admin-cp/load-data/loadCountries',
            dataType: 'json',
            data: function (params) {
                let explodes = $(this).data('explodes') ? $(this).data('explodes') : null;
                if (explodes) {
                    explodes = $("." + explodes).map(function () {return $(this).val();}).get();
                }

                var query = {
                    search: $.trim(params.term),
                    page: params.page,
                    explodes: explodes,
                };

                return query;
            }
        },
    });

    $('.load-actors').select2({
        allowClear: true,
        width: '100%',
        placeholder: function (params) {
            return {
                id: null,
                text: params.placeholder,
            }
        },
        ajax: {
            method: 'GET',
            url: '/admin-cp/load-data/loadActors',
            dataType: 'json',
            data: function (params) {
                let explodes = $(this).data('explodes') ? $(this).data('explodes') : null;
                if (explodes) {
                    explodes = $("." + explodes).map(function () {return $(this).val();}).get();
                }

                var query = {
                    search: $.trim(params.term),
                    page: params.page,
                    explodes: explodes,
                };

                return query;
            }
        },
    });

    $('.load-directors').select2({
        allowClear: true,
        width: '100%',
        placeholder: function (params) {
            return {
                id: null,
                text: params.placeholder,
            }
        },
        ajax: {
            method: 'GET',
            url: '/admin-cp/load-data/loadDirectors',
            dataType: 'json',
            data: function (params) {
                let explodes = $(this).data('explodes') ? $(this).data('explodes') : null;
                if (explodes) {
                    explodes = $("." + explodes).map(function () {return $(this).val();}).get();
                }

                var query = {
                    search: $.trim(params.term),
                    page: params.page,
                    explodes: explodes,
                };

                return query;
            }
        },
    });

    $('.load-writers').select2({
        allowClear: true,
        width: '100%',
        placeholder: function (params) {
            return {
                id: null,
                text: params.placeholder,
            }
        },
        ajax: {
            method: 'GET',
            url: '/admin-cp/load-data/loadWriters',
            dataType: 'json',
            data: function (params) {
                let explodes = $(this).data('explodes') ? $(this).data('explodes') : null;
                if (explodes) {
                    explodes = $("." + explodes).map(function () {return $(this).val();}).get();
                }

                var query = {
                    search: $.trim(params.term),
                    page: params.page,
                    explodes: explodes,
                };

                return query;
            }
        },
    });

    $('.load-tags').select2({
        allowClear: true,
        width: '100%',
        placeholder: function (params) {
            return {
                id: null,
                text: params.placeholder,
            }
        },
        ajax: {
            method: 'GET',
            url: '/admin-cp/load-data/loadTags',
            dataType: 'json',
            data: function (params) {
                let explodes = $(this).data('explodes') ? $(this).data('explodes') : null;
                if (explodes) {
                    explodes = $("." + explodes).map(function () {return $(this).val();}).get();
                }

                var query = {
                    search: $.trim(params.term),
                    page: params.page,
                    explodes: explodes,
                };

                return query;
            }
        },

    });

    $('.load-post-categories').select2({
        allowClear: true,
        width: '100%',
        placeholder: function (params) {
            return {
                id: null,
                text: params.placeholder,
            }
        },
        ajax: {
            method: 'GET',
            url: '/admin-cp/load-data/loadPostCategories',
            dataType: 'json',
            data: function (params) {
                let explodes = $(this).data('explodes') ? $(this).data('explodes') : null;
                if (explodes) {
                    explodes = $("." + explodes).map(function () {return $(this).val();}).get();
                }

                var query = {
                    search: $.trim(params.term),
                    page: params.page,
                    explodes: explodes,
                };

                return query;
            }
        },

    });

    $('.load-users').select2({
        allowClear: true,
        width: '100%',
        placeholder: function (params) {
            return {
                id: null,
                text: params.placeholder,
            }
        },
        ajax: {
            method: 'GET',
            url: '/admin-cp/load-data/loadUsers',
            dataType: 'json',
            data: function (params) {
                let explodes = $(this).data('explodes') ? $(this).data('explodes') : null;
                if (explodes) {
                    explodes = $("." + explodes).map(function () {return $(this).val();}).get();
                }

                var query = {
                    search: $.trim(params.term),
                    page: params.page,
                    explodes: explodes,
                };

                return query;
            }
        },
    });
});