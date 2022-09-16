class JuzawebListView {
    constructor(e) {
        this.url = e.url;
        this.list = (e.list) ? e.list : '.juzaweb-list';
        this.method = (e.method) ? e.method : 'get';
        this.template = (e.template) ? e.template : '';
        this.sort_name = (e.sort_name) ? e.sort_name : 'id';
        this.sort_order = (e.sort_order) ? e.sort_order : 'desc';
        this.page_size = (e.page_size) ? e.page_size: 10;
        this.after_load_callback = (e.after_load_callback) ? e.after_load_callback: null;
        this.offset = 0;
        this.total = 0;
        this.page = 1;

        this.init();
    }

    init () {
        let item = this;
        item.loadData();

        $(window).scroll(function () {
            if ($(window).scrollTop() === $(document).height() - $(window).height()) {
                if (item.offset + item.page_size < item.total) {
                    item.page = item.page + 1;
                    item.loadData();
                }
            }
        });
    }

    loadData() {
        let template = document.getElementById(this.template).innerHTML;
        let result = $(this.list);

        if (this.page > 1) {
            this.offset = (this.page * this.page_size) - this.page_size;
        }

        let jqxhr = $.ajax({
            type: this.method,
            url: this.url,
            dataType: 'json',
            cache: false,
            async: false,
            data: {
                page: this.page,
                limit: this.page_size
            }
        });

        let response = jqxhr.responseJSON;
        this.total = response.meta.total;

        let html = '';
        if (response.data.length > 0) {
            $.each(response.data, function (index, item) {
                html += replace_template(template, item)
            });

            result.append(html);
        }

        if (this.after_load_callback) {
            eval(this.after_load_callback)();
        }
    }
}
