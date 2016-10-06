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

    mounted() {
        this.$nextTick( () => this.getPagination() )
    },

    methods: {
        getSpecByCategory(category) {
            this.setSpecCategory(category);
            this.getPagination();
        },

        setSpecCategory(category) {
            this.category = category;
        },

        setPagination(obj) {
            this.pagination = obj;
            this.closeResultDialog();
        },

        getPagination(num = "") {
            var route = laroute.route('api.search.internal');
            this.$http.get(route, {
                params: {
                    page: num,
                    category: this.category.category_no
                }
            })
                .then(
                    (response) => this.setPagination(response.json()),
                    () => errorDialogMessage()
                );
        },

        prev() {
            this.getPagination(this.pagination.current_page - 1);
        },

        next() {
            this.getPagination(this.pagination.current_page + 1);
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
                .then(
                    () => this.delete(this.modalDeleteConfirmation.category),
                    () => errorDialogMessage()
                );
        },
    },

    delete(spec) {
        var index = this.pagination.data.indexOf(spec);
        this.pagination.data.splice(index, 1);
        this.resetModalData();
    },

    errorDialogMessage() {
        return alert("Oops, server error!. Try refreshing your browser. \n \n if this message box keeps on coming contact system administrator");
    },
});