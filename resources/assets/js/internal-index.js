require('./app');
import abstract from "./mixins/abstract";
import search from "./mixins/search";
import filter from "./mixins/filterMethods";

const app = new Vue({
    el: "#app",

    data: {
        category,

        modalConfirmation: {
            category: {},
            index: -1
        },

        pagination: {},
    },

    mixins: [abstract, search, filter],

    methods: {
        getPagination(num = "") {
            var pagination_url = laroute.route('api.search.internal');
            this.fetchData(pagination_url, num, this.category.category_no);
        },

        setModalSpec(spec) {
            this.modalConfirmation.category = spec;
        },

        removeSpec() {
            var delete_route = laroute.route("internal.destroy", {internal: this.modalConfirmation.category.id});
            this.destroyData(delete_route);
        },

        isNewRevision(revision_date) {
            var revision_date = moment(revision_date);
            return revision_date > moment().subtract(7, "days");
        },
    },
});