class LoadBootstrapTable {

    constructor(e) {
        this.url = e.url;
        this.remove_url = e.remove_url;
        this.status_url = e.status_url;
        this.remove_question = (e.remove_question) ? e.remove_question : langs.are_you_sure_delete_items;
        this.detete_button = (e.detete_button) ? e.detete_button : "#delete-item";
        this.status_button = (e.status_button) ? e.status_button : ".status-button";
        this.table = (e.table) ? e.table : '.load-bootstrap-table';
        this.field_id = (e.field_id) ? e.field_id : 'id';
        this.form_search = (e.form_search) ? e.form_search : "#form-search";
        this.sort_name = (e.sort_name) ? e.sort_name : 'id';
        this.sort_order = (e.sort_order) ? e.sort_order : 'desc';
        this.page_size = (e.page_size) ? e.page_size : 10;
        this.search = (e.search) ? e.search : false;
        this.method = (e.method) ? e.method : 'get';
        this.locale = (e.locale) ? e.locale : 'vi-VN';

        this.init();
    }

    init() {
        let btn_delete = $(this.detete_button);
        let btn_status = $(this.status_button);

        btn_delete.prop('disabled', true);
        btn_status.prop('disabled', true);
        $('.items-checked').prop('disabled', true);

        let table = $(this.table);
        let form_search = this.form_search;
        let remove_url = this.remove_url;
        let status_url = this.status_url;
        let remove_question = this.remove_question;
        let data_url = this.url;
        let field_id = this.field_id;
        let method = this.method;
        let locale = this.locale;

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
                let field_search = $(form_search).serializeArray();
                $.each(field_search, function (i, item) {
                    if (params[item.name]) {
                        params[item.name] += ';' + item.value;
                    }
                    else {
                        params[item.name] = item.value;
                    }

                });
                return params;
            }
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
            'check-all.bs.table uncheck-all.bs.table', () => {
            $('.items-checked').prop('disabled', !table.bootstrapTable('getSelections').length);
            btn_delete.prop('disabled', !table.bootstrapTable('getSelections').length);
            btn_status.prop('disabled', !table.bootstrapTable('getSelections').length);
        });

        btn_delete.on('click', function () {
            let ids = $("input[name=btSelectItem]:checked").map(function () {
                return $(this).val();
            }).get();
            Swal.fire({
                title: '',
                text: remove_question,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!',
                cancelButtonText: 'Cancel!',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: remove_url,
                        dataType: 'json',
                        data: {
                            'ids': ids
                        },
                        success: function (result) {
                            if (result.status === "success") {
                                table.bootstrapTable('refresh');
                                return false;
                            }
                            else {
                                show_message(result.message, result.status);
                                return false;
                            }
                        }
                    });
                }
            });

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
                    if (result.status === "success") {
                        table.bootstrapTable('refresh');

                        return false;
                    }
                    else {
                        show_message(result.message, result.status);
                        return false;
                    }
                }
            });

            return false;
        });
    }

    refresh() {
        $(this.table).bootstrapTable('refresh');
    }
}