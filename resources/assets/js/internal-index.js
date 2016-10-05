require('./app');
import search from "./mixins/search";

const app = new Vue({
    el: "#app",

    data: {
        category,

        modalDeleteConfirmation: {
            category: {},
            index: -1
        },

        pagination: {},
    },
    mixins: [search],

    ready() {
        this.getPagination();
    },

    methods: {
        getSpecByCategory(category) {
            this.setSpecCategory(category);
            this.getPagination();
        },

        setSpecCategory(category) {
            this.category = category;
        },

        getPagination(num = "") {
            var route = laroute.route('api.search.internal');
            this.$http.get(route, {
                params: {
                    page: num,
                    category: this.category.category_no
                }
            })
                .then( response => {
                    this.pagination = response.json();
                    this.closeResultDialog();
                }, () => this.getPagination(num));
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

        setModalSpec(spec) {
            this.modalDeleteConfirmation.category = spec;
        },

        resetModalData() {
            this.setModalSpec({});
        },

        removeSpec() {
            var delete_route = laroute.route("internal.destroy", {internal: this.modalDeleteConfirmation.category.id});

            this.$http.delete(delete_route)
                .then( () => {
                    this.pagination.data.$remove(this.modalDeleteConfirmation.category);
                    this.resetModalData();
                }, this.removeSpec());
        },
    }
});