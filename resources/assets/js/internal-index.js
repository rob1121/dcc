require('./app');
import abstract from "./mixins/abstract";
import { toUpper, capitalize } from "./modules/stringformatter";
import { telfordStandardDate } from "./modules/dateFormatter";
const app = new Vue({
    el: "#app",

    data: {
        category,

        modalConfirmation: {
            category: {},
            index: -1
        },

        pagination: {},
        searchKey: ""
    },

    computed: {
        documents() {
            return _.filter(this.pagination, (o) => o.spec_name.toLowerCase().includes(this.searchKey.toLowerCase()));
        }
    },

    mixins: [abstract],

    filters: {
        toUpper,
        capitalize,
        telfordStandardDate
    },

    methods: {
        getPagination() {
            var pagination_url = laroute.route('api.search.internal');
            this.fetchData(pagination_url, this.category.category_no);
        },

        setModalSpec(spec) {
            this.modalConfirmation.category = spec;
        },

        removeSpec() {
            var delete_route = laroute.route("internal.destroy", {internal: this.modalConfirmation.category.id});
            this.destroyData(delete_route);
        }
    }
});