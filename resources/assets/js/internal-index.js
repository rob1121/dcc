require('./app');
import abstract from "./mixins/abstract";
import { searchKey, searchCategoryKey, activeCategory, setActiveCategory, setSearchCategoryKey, emptySearchKey } from "./modules/SidebarModules";
import { toUpper, capitalize } from "./modules/stringformatter";
import { telfordStandardDate } from "./modules/dateFormatter";

const app = new Vue({
    el: "#app",

    data: {
        modalConfirmation: {
            category: {},
            index: -1
        },

        pagination: {},
        searchKey,
        searchCategoryKey,
        activeCategory
    },

    computed: {
        documentsByCategory() {
            let document = this.pagination;

            if (this.searchCategoryKey === null && this.pagination.length > 0)
                this.searchCategoryKey = this.pagination[0].company_spec_category.category_no;

            if(this.searchCategoryKey !== "")
                document = _.filter(this.pagination, (o) => {
                    return o.company_spec_category.category_no.toLowerCase() === this.searchCategoryKey.toLowerCase();
                });

            return document;
        },

        documents() {
            return this.searchKey === ""
                ? this.documentsByCategory
                : _.filter( this.pagination, (o) => o.spec_name.toLowerCase().includes(this.searchKey.toLowerCase()) );
        }
    },

    mixins: [abstract],

    filters: {
        toUpper,
        capitalize,
        telfordStandardDate
    },

    methods: {
        setActiveCategory,
        setSearchCategoryKey,
        emptySearchKey,

        getPagination() {
            var pagination_url = laroute.route('api.search.internal');
            this.fetchData(pagination_url);
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