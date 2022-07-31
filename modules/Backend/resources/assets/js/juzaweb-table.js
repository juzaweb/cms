class JuzawebTable {

    constructor(e) {
        this.url = e.url;
        this.action_url = e.action_url;
        this.remove_url = e.remove_url || null;
        this.status_url = e.status_url || null;
        this.remove_question = (e.remove_question) ? e.remove_question: juzaweb.lang.remove_question.replace(':name', juzaweb.lang.the_selected_items);
        this.detete_button = (e.detete_button) ? e.detete_button : "#delete-item";
        this.status_button = (e.status_button) ? e.status_button : ".status-button";
        this.apply_button = (e.apply_button) ? e.apply_button: "#apply-action";
        this.table = (e.table) ? e.table : '.juzaweb-table';
        this.field_id = (e.field_id) ? e.field_id : 'id';
        this.form_search = (e.form_search) ? e.form_search : "#form-search";
        this.sort_name = (e.sort_name) ? e.sort_name : 'id';
        this.sort_order = (e.sort_order) ? e.sort_order : 'desc';
        this.page_size = (e.page_size) ? e.page_size: 10;
        this.search = (e.search) ? e.search : false;
        this.method = (e.method) ? e.method : 'get';
        this.locale = (e.locale) ? e.locale : 'en-US';
        this.chunk_action = (e.chunk_action) ? e.chunk_action : false;
        this.inputRow = "";
        this.init();
    }

    init() {
        let apply_button = $(this.apply_button);
        let btn_status = $(this.status_button);
        let bulkActionButton = $('.bulk-actions-button');

        apply_button.prop('disabled', true);
        btn_status.prop('disabled', true);
        bulkActionButton.prop('disabled', true);

        let table = $(this.table);
        let form_search = this.form_search;
        let action_url = this.action_url;
        let remove_question = this.remove_question;
        let data_url = this.url;
        let field_id = this.field_id;
        let method = this.method;
        let locale = this.locale;
        let status_url = this.status_url;
        let chunk_action = this.chunk_action;

        table.bootstrapTable({
            url: data_url,
            idField: field_id,
            method: method,
            locale: locale,
            sidePagination: 'server',
            pagination: true,
            sortName: this.sort_name,
            sortOrder: this.sort_order,
            toggle: 'table',
            search: this.search,
            pageSize: this.page_size,
            queryParams: function (params) {
                let fieldSearch = $(form_search).serializeArray();
                $.each(fieldSearch, function (i, item) {
                    if (params[item.name]) {
                        params[item.name] += ',' + item.value;
                    } else {
                        params[item.name] = item.value;
                    }
                });
                return params;
            }
        });

        function action_button() {
            let tblSelection = !table.bootstrapTable('getSelections').length;
            apply_button.prop('disabled', tblSelection);
            bulkActionButton.prop('disabled', tblSelection);
        }

        $(this.form_search).on('change', 'select, input', function (event) {
            if (event.isDefaultPrevented()) {
                return false;
            }

            event.preventDefault();
            table.bootstrapTable('refresh');
            return false;
        });

        $(this.form_search).on('submit', function (event) {
            if (event.isDefaultPrevented()) {
                return false;
            }

            event.preventDefault();
            table.bootstrapTable('refresh');
            return false;
        });

        table.on('check.bs.table uncheck.bs.table ' +
            'check-all.bs.table uncheck-all.bs.table ' +
            'pre-body.bs.table', () => {
            action_button();
        });

        apply_button.on('click', function () {
            let btn = $(this);
            let form = btn.closest('form');
            let text = btn.html();
            let action = form.find('select[name=bulk_actions]').val();
            let token = form.find('input[name=_token]').val();
            let ids = $("input[name=btSelectItem]:checked").map(function(){return $(this).val();}).get();

            if (!ids || !action) {
                return false;
            }

            if (action == 'delete') {
                confirm_message(remove_question, function (result) {
                    if (!result) {
                        return false;
                    }

                    btn.html(juzaweb.lang.please_wait);
                    btn.prop("disabled", true);

                    ajaxRequest(action_url, {
                        'ids': ids,
                        'action': action,
                        '_token': token
                    }, {
                        callback: function (response) {
                            btn.prop("disabled", false);
                            btn.html(text);

                            if (response.status === true) {
                                show_message(response);

                                if (response.data.window_redirect) {
                                    window.location = response.data.window_redirect;
                                    return false;
                                }

                                if (response.data.redirect) {
                                    setTimeout(function () {
                                        window.location = response.data.redirect;
                                    }, 1000);
                                    return false;
                                }

                                table.bootstrapTable('refresh');
                                $('select[name=bulk_actions]').val(null).trigger('change.select2');
                                return false;
                            } else {
                                show_message(response);
                                return false;
                            }
                        }
                    });
                });
            } else {
                btn.html(juzaweb.lang.please_wait);
                btn.prop("disabled", true);

                if (chunk_action) {
                    let items = $("input[name=btSelectItem]:checked");
                    setTimeout(function () {
                        let response;
                        process_each(items, function () {
                            let id = $(this).val();
                            $(this).hide();
                            $(this).closest('label')
                                .find('span')
                                .html(`<i class="fa fa-spinner fa-spin"></i>`);

                            response = ajaxRequest(action_url, {
                                'ids': [id],
                                'action': action,
                                '_token': token
                            }, {
                                async: false,
                                callback: function (response) {
                                    return false;
                                }
                            });

                            return response;
                        }, 500, {
                            completeCallback: function (response) {
                                show_message(response);

                                if (response.data.redirect) {
                                    setTimeout(function () {
                                        window.location = response.data.redirect;
                                    }, 1000);
                                    return false;
                                }

                                if (response.data.window_redirect) {
                                    setTimeout(function () {
                                        window.location = response.data.window_redirect;
                                    }, 1000);
                                    return false;
                                }

                                btn.prop("disabled", false);
                                btn.html(text);

                                table.bootstrapTable('refresh');

                                $('select[name=bulk_actions]').val(null).trigger('change.select2');
                            }
                        });

                    }, 500);

                } else {
                    ajaxRequest(action_url, {
                        'ids': ids,
                        'action': action,
                        '_token': token
                    }, {
                        callback: function (response) {
                            if (response.status === true) {
                                show_message(response);

                                if (response.data.window_redirect) {
                                    window.location = response.data.window_redirect;
                                    return false;
                                }

                                if (response.data.redirect) {
                                    setTimeout(function () {
                                        window.location = response.data.redirect;
                                    }, 1000);
                                    return false;
                                }

                                if (response.data.window_redirect) {
                                    setTimeout(function () {
                                        window.location = response.data.window_redirect;
                                    }, 1000);
                                    return false;
                                }

                                btn.prop("disabled", false);
                                btn.html(text);

                                table.bootstrapTable('refresh');
                                $('select[name=bulk_actions]').val(null).trigger('change.select2');
                                return false;
                            } else {
                                show_message(response);
                                return false;
                            }
                        }
                    });
                }
            }

            return false;
        });

        $('.bulk-actions-actions').on('click', '.select-action', function () {
            let btn = bulkActionButton;
            let text = btn.html();
            let action = $(this).data('action');
            let form = $(this).closest('form');
            let token = form.find('input[name=_token]').val();
            let ids = $("input[name=btSelectItem]:checked").map(function(){return $(this).val();}).get();
            bulkActionButton.dropdown('toggle');

            if (!ids || !action) {
                return false;
            }

            if (action == 'delete') {
                confirm_message(remove_question, function (result) {
                    if (!result) {
                        return false;
                    }

                    btn.html(juzaweb.lang.please_wait);
                    btn.prop("disabled", true);

                    ajaxRequest(action_url, {
                        'ids': ids,
                        'action': action,
                        '_token': token
                    }, {
                        callback: function (response) {
                            btn.prop("disabled", false);
                            btn.html(text);

                            if (response.status === true) {
                                show_message(response);

                                if (response.data.window_redirect) {
                                    window.location = response.data.window_redirect;
                                    return false;
                                }

                                if (response.data.redirect) {
                                    setTimeout(function () {
                                        window.location = response.data.redirect;
                                    }, 1000);
                                    return false;
                                }

                                table.bootstrapTable('refresh');
                                return false;
                            } else {
                                show_message(response);
                                return false;
                            }
                        }
                    });
                });
            } else {
                btn.html(juzaweb.lang.please_wait);
                btn.prop("disabled", true);

                if (chunk_action) {
                    let items = $("input[name=btSelectItem]:checked");
                    setTimeout(function () {
                        let response;
                        process_each(items, function () {
                            let id = $(this).val();
                            $(this).hide();
                            $(this).closest('label')
                                .find('span')
                                .html(`<i class="fa fa-spinner fa-spin"></i>`);

                            response = ajaxRequest(action_url, {
                                'ids': [id],
                                'action': action,
                                '_token': token
                            }, {
                                async: false,
                                callback: function (response) {
                                    return false;
                                }
                            });

                            return response;
                        }, 500, {
                            completeCallback: function (response) {
                                show_message(response);

                                if (response.data.redirect) {
                                    setTimeout(function () {
                                        window.location = response.data.redirect;
                                    }, 1000);
                                    return false;
                                }

                                if (response.data.window_redirect) {
                                    setTimeout(function () {
                                        window.location = response.data.window_redirect;
                                    }, 1000);
                                    return false;
                                }

                                btn.prop("disabled", false);
                                btn.html(text);

                                table.bootstrapTable('refresh');
                            }
                        });

                    }, 500);

                } else {
                    ajaxRequest(action_url, {
                        'ids': ids,
                        'action': action,
                        '_token': token
                    }, {
                        callback: function (response) {
                            if (response.status === true) {
                                show_message(response);

                                if (response.data.window_redirect) {
                                    window.location = response.data.window_redirect;
                                    return false;
                                }

                                if (response.data.redirect) {
                                    setTimeout(function () {
                                        window.location = response.data.redirect;
                                    }, 1000);
                                    return false;
                                }

                                if (response.data.window_redirect) {
                                    setTimeout(function () {
                                        window.location = response.data.window_redirect;
                                    }, 1000);
                                    return false;
                                }

                                btn.prop("disabled", false);
                                btn.html(text);

                                table.bootstrapTable('refresh');
                                return false;
                            } else {
                                show_message(response);
                                return false;
                            }
                        }
                    });
                }
            }

            return false;
        });

        btn_status.on('click', function () {
            let ids = $("input[name=btSelectItem]:checked").map(function () {return $(this).val();}).get();
            let status = $(this).data('status');

            if (ids.length <= 0) {
                return false;
            }

            $.ajax({
                type: "POST",
                url: status_url,
                dataType: 'json',
                data: {
                    'ids': ids,
                    'status': status,
                },
                success: function (result) {
                    if (result.status === true) {
                        table.bootstrapTable('refresh');
                        btn_status.prop('disabled', true);
                        $('.items-checked').prop('disabled', true);
                        return false;
                    } else {
                        show_message(result);
                        return false;
                    }
                }
            });

            return false;
        });

        table.on('click', '.action-item', function () {
            let ids = [$(this).data('id')];
            let action = $(this).data('action');

            if (action == 'delete') {
                Swal.fire({
                    title: '',
                    text: remove_question,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: juzaweb.lang.yes + '!',
                    cancelButtonText: juzaweb.lang.cancel + '!',
                }).then((result) => {
                    if (result.value) {
                        $(this).html(juzaweb.lang.please_wait);

                        $.ajax({
                            type: "POST",
                            url: action_url,
                            dataType: 'json',
                            data: {
                                'ids': ids,
                                'action': action
                            },
                            success: function (response) {
                                if (response.data.window_redirect) {
                                    show_message(response);
                                    window.location = response.data.window_redirect;
                                    return false;
                                }

                                if (response.data.redirect) {
                                    show_message(response);
                                    setTimeout(function () {
                                        window.location = response.data.redirect;
                                    }, 1000);
                                    return false;
                                }

                                table.bootstrapTable('refresh');
                            }
                        });
                    }
                });
            } else {
                $(this).html(juzaweb.lang.please_wait);

                $.ajax({
                    type: "POST",
                    url: action_url,
                    dataType: 'json',
                    data: {
                        'ids': ids,
                        'action': action
                    },
                    success: function (response) {
                        if (response.data.window_redirect) {
                            show_message(response);
                            window.location = response.data.window_redirect;
                            return false;
                        }

                        if (response.data.redirect) {
                            show_message(response);
                            setTimeout(function () {
                                window.location = response.data.redirect;
                            }, 1000);
                            return false;
                        }

                        table.bootstrapTable('refresh');
                    }
                });
            }

            return false;
        });
    }

    refresh(options = {}) {
        if (options) {
            $(this.table).bootstrapTable('refreshOptions', options);
        } else {
            $(this.table).bootstrapTable('refresh', options);
        }
    }
}
