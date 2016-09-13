require('./app');

const app = new Vue({
    el: "#app",

    data: {
        spec: {
            category
        },
        currentIndex: 0,

        pagination: {},
        searchText: "",
        modal: {
            spec: {}
        }
    },

    ready() {
        this.getPagination();
    },

    filters: {
        trim(string) {
                if(string.length <= 64)     return string;
                else if(64 <= 3)            return string.slice(0, 64) + "...";
                else                        return string.slice(0, 64 - 3) + "...";
        },

        isCurrentIndex(index) {
            return index === this.currentIndex;
        }
    },

    methods: {
        getSpecByCategory(category_no, index) {
            this.setSpecCategory(category_no);
            this.getPagination();
            this.setActiveMenu(index);
        },

        setSpecCategory(category_no) {
            this.spec.category = category_no;
        },

        setActiveMenu(index) {
            this.currentIndex = index;
        },

        getPagination(num = "") {
            var loader = $(".loader");
            loader.show();
            this.$http.get(`/api/company-spec?page=${num}&category=${this.spec.category}`)
                .then( response => {
                    this.pagination = response.json();
                    loader.hide();
                } );
        },

        prev() {
            this.getPagination(this.pagination.current_page - 1);
        },

        next() {
            this.getPagination(this.pagination.current_page + 1);
        },

        showSideBar() {
            $('#sidebar').toggleClass("show-sidebar");
            $('.main-content').toggleClass("compress-main-content");

            this.toggleButton();
        },

        toggleButton() {
            var btn = $('.toggler-btn');

            btn.children('i').toggleClass("fa-bars");
            btn.children('i').toggleClass("fa-remove");
        },

        setModalSpec(spec, index) {
            this.modal.spec = spec;
            this.modal.index = index;
        },

        resetModalData() {
            this.setModalSpec({}, null);
        },

        removeSpec() {
            this.$http.delete(`/internal/${this.modal.spec.id}`).then( () => {
                this.pagination.data.$remove(this.modal.spec);
                this.resetModalData();
            } ).bind(this);
        },
    }
});