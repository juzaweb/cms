function initSelect2(parent = 'body')
{
    $(parent +' .select2').select2({
        allowClear: true,
        dropdownAutoWidth: !$(this).data('width'),
        width: $(this).data('width') || '100%',
        placeholder: function (params) {
            return {
                id: null,
                text: params.placeholder,
            }
        },
    });

    $(parent +' .select2-default').select2({
        width: $(this).data('width') || '100%',
        dropdownAutoWidth: !$(this).data('width'),
    });

    $(parent +' .load-taxonomies').select2({
        allowClear: true,
        dropdownAutoWidth: !$(this).data('width'),
        width: $(this).data('width') || '100%',
        placeholder: function(params) {
            return {
                id: null,
                text: params.placeholder,
            }
        },
        ajax: {
            method: 'GET',
            url: juzaweb.adminUrl +'/load-data/loadTaxonomies',
            dataType: 'json',
            data: function (params) {
                let postType = $(this).data('post-type');
                let taxonomy = $(this).data('taxonomy');
                let explodes = $(this).data('explodes');
                if (explodes) {
                    explodes = $("." + explodes).map(function () {
                        return $(this).val();
                    }).get();
                }

                return {
                    search: $.trim(params.term),
                    page: params.page,
                    explodes: explodes,
                    post_type: postType,
                    taxonomy: taxonomy
                };
            }
        }
    });

    $(parent +' .load-users').select2({
        allowClear: true,
        dropdownAutoWidth: !$(this).data('width'),
        width: $(this).data('width') || '100%',
        placeholder: function (params) {
            return {
                id: null,
                text: params.placeholder,
            }
        },
        ajax: {
            method: 'GET',
            url: '/'+ juzaweb.adminPrefix +'/load-data/loadUsers',
            dataType: 'json',
            data: function (params) {
                let explodes = $(this).data('explodes') ? $(this).data('explodes') : null;
                if (explodes) {
                    explodes = $("." + explodes).map(function () {return $(this).val();}).get();
                }

                return {
                    search: $.trim(params.term),
                    page: params.page,
                    explodes: explodes,
                };
            }
        },
    });

    $(parent +' .load-menu').select2({
        allowClear: true,
        dropdownAutoWidth: !$(this).data('width'),
        width: $(this).data('width') || '100%',
        placeholder: function (params) {
            return {
                id: null,
                text: params.placeholder,
            }
        },
        ajax: {
            method: 'GET',
            url: '/'+ juzaweb.adminPrefix +'/load-data/loadMenu',
            dataType: 'json',
            data: function (params) {
                let explodes = $(this).data('explodes') ? $(this).data('explodes') : null;
                if (explodes) {
                    explodes = $("." + explodes).map(function () {return $(this).val();}).get();
                }

                return {
                    search: $.trim(params.term),
                    page: params.page,
                    explodes: explodes,
                };
            }
        },
    });

    $(parent +' .load-pages').select2({
        allowClear: true,
        dropdownAutoWidth: !$(this).data('width'),
        width: $(this).data('width') || '100%',
        placeholder: function (params) {
            return {
                id: null,
                text: params.placeholder,
            }
        },
        ajax: {
            method: 'GET',
            url: '/'+ juzaweb.adminPrefix +'/load-data/loadPages',
            dataType: 'json',
            data: function (params) {
                return {
                    search: $.trim(params.term),
                    page: params.page
                };
            }
        },
    });

    $(parent +' .load-posts').select2({
        allowClear: true,
        dropdownAutoWidth: !$(this).data('width'),
        width: $(this).data('width') || '100%',
        placeholder: function (params) {
            return {
                id: null,
                text: params.placeholder,
            }
        },
        ajax: {
            method: 'GET',
            url: '/'+ juzaweb.adminPrefix +'/load-data/loadPosts',
            dataType: 'json',
            data: function (params) {
                let type = $(this).data('type') ? $(this).data('type') : null;
                return {
                    search: $.trim(params.term),
                    page: params.page,
                    type: type,
                };
            }
        },
    });

    $(parent +' .load-locales').select2({
        allowClear: true,
        dropdownAutoWidth: !$(this).data('width'),
        width: $(this).data('width') || '100%',
        placeholder: function (params) {
            return {
                id: null,
                text: params.placeholder,
            }
        },
        ajax: {
            method: 'GET',
            url: '/'+ juzaweb.adminPrefix +'/load-data/loadLocales',
            dataType: 'json',
            data: function (params) {
                let type = $(this).data('type') ? $(this).data('type') : null;
                let explodes = $(this).data('explodes') ? $(this).data('explodes') : null;
                return {
                    search: $.trim(params.term),
                    page: params.page,
                    type: type,
                    explodes: explodes
                };
            }
        },
    });

    $(parent +' .load-select2').select2({
        allowClear: true,
        dropdownAutoWidth: !$(this).data('width'),
        width: $(this).data('width') || '100%',
        placeholder: function (params) {
            return {
                id: null,
                text: params.placeholder,
            }
        },
        ajax: {
            method: 'GET',
            url: $(this).data('url') || '',
            dataType: 'json',
            data: function (params) {
                return {
                    search: $.trim(params.term),
                    page: params.page
                };
            }
        },
    });

    $(parent +' .load-resources').select2({
        allowClear: true,
        dropdownAutoWidth: !$(this).data('width'),
        width: $(this).data('width') || '100%',
        placeholder: function(params) {
            return {
                id: null,
                text: params.placeholder,
            }
        },
        ajax: {
            method: 'GET',
            url: juzaweb.adminUrl +'/load-data/loadResource',
            dataType: 'json',
            data: function (params) {
                let type = $(this).data('type');
                let explodes = $(this).data('explodes');

                if (explodes) {
                    explodes = $("." + explodes).map(function () {
                        return $(this).val();
                    }).get();
                }

                return {
                    search: $.trim(params.term),
                    page: params.page,
                    explodes: explodes,
                    type: type
                };
            }
        }
    });

    $(parent +' .load-subscription-objects').select2({
        allowClear: true,
        dropdownAutoWidth: !$(this).data('width'),
        width: $(this).data('width') || '100%',
        placeholder: function(params) {
            return {
                id: null,
                text: params.placeholder,
            }
        },
        ajax: {
            method: 'GET',
            url: juzaweb.adminUrl +'/load-data/loadSubscriptionObjects',
            dataType: 'json',
            data: function (params) {
                let module = $(this).data('module');

                return {
                    search: $.trim(params.term),
                    page: params.page,
                    module: module
                };
            }
        }
    });
}

$(document).ready(function () {
    initSelect2('body');
});
