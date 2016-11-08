require('./app');
import abstract from "./mixins/abstract";
import { modalConfirmation, setModalSpec } from "./modules/modalConfirmationModule";
import { searchKey, searchCategoryKey, activeCategory, setActiveCategory, setSearchCategoryKey, emptySearchKey } from "./modules/SidebarModules";
import { toUpper, capitalize } from "./modules/stringformatter";
import { telfordStandardDate } from "./modules/dateFormatter";

const app = new Vue({
    el: "#app",

    data: {
        modalConfirmation,

        pagination: {},
        searchKey,
        searchCategoryKey,
        activeCategory,
        navToggler: false
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
                : _.filter(
                    this.pagination, (o) => o.spec_name.toLowerCase().includes(this.searchKey.toLowerCase())
                        || o.revision_summary.toLowerCase().includes(this.searchKey.toLowerCase())
                );
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
        setModalSpec,

        getPagination() {
            var pagination_url = laroute.route('api.search.internal');
            this.fetchData(pagination_url);
        },

        removeSpec() {
            var delete_route = laroute.route("internal.destroy", {internal: this.modalConfirmation.category.id});
            this.destroyData(delete_route);
        }
    }
});