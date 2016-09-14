require('./app');

const app = new Vue({
    el: "#app",

    data: {
        category: {
            category_no,
            category_name
        },

        currentIndex: 0,

        pagination: {},
        searchText: "",
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
        getSpecByCategory(category, index) {
            this.setSpecCategory(category);
            this.getPagination();
            this.setActiveMenu(index);
        },

        setSpecCategory(category) {
            this.category = category;
        },

        setActiveMenu(index) {
            this.currentIndex = index;
        },

        getPagination(num = "") {
            var loader = $(".loader");
            loader.show();
            this.$http.get(`${env_server}/api/company-spec?page=${num}&category=${this.category.category_no}`)
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
            this.modal.category = spec;
            this.modal.index = index;
        },

        resetModalData() {
            this.setModalSpec({}, null);
        },

        removeSpec() {
            this.$http.delete(`/internal/${this.modal.category.id}`).then( () => {
                this.pagination.data.$remove(this.modal.category);
                this.resetModalData();
            } ).bind(this);
        },
    }
});