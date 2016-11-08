require("./app");
import abstract from "./mixins/abstract";
import { searchKey, searchCategoryKey, activeCategory, setActiveCategory, setSearchCategoryKey, emptySearchKey } from "./modules/SidebarModules";
import { toUpper, capitalize } from "./modules/stringformatter";
import { telfordStandardDate } from "./modules/dateFormatter";

const app = new Vue({
	el: "#app",

	data: {
        status_filter: "all",

		modalConfirmation: {
		    action: "update",
			category: [],
            indexOfSpecForUpdate: null
		},

        pagination: [],
        searchKey,
        searchCategoryKey,
        activeCategory
    },

    computed: {
        documentsByCategory() {
            let document = this.externalSpecs;

            if (this.searchCategoryKey === null && this.externalSpecs.length > 0)
                this.searchCategoryKey = this.externalSpecs[0].customer_spec_category.customer_name;

            if(this.searchCategoryKey !== "")
                document = _.filter(this.externalSpecs, (o) => {
                    return o.customer_spec_category.customer_name.toLowerCase() === this.searchCategoryKey.toLowerCase();
                });

            return document;
        },

        documents() {
            return this.searchKey === ""
                ? this.documentsByCategory
                : _.filter(
                this.pagination, (o) => o.spec_name.toLowerCase().includes(this.searchKey.toLowerCase())
                || o.customer_spec_category.customer_name.toLowerCase().includes(this.searchKey.toLowerCase())
            );
        },

        customerSpecForReview() {
            return this.getCustomerSpecsForReview(
                this.modalConfirmation.category.customer_spec_revision
            );
        },

        externalSpecs() {
            if(this.status_filter === "all" ) return this.pagination;

            return _.filter(this.pagination, spec => _.find(spec.customer_spec_revision, {is_reviewed: 0}));
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

        externalRouteFor(specRevision) {
            const spec = _.sortBy(specRevision, ['revision'])[specRevision.length-1];

            return laroute.route('external.show', {
                external: specRevision.customer_spec_id,
                revision: specRevision.revision
            });
        },

        getCustomerSpecsForReview(specs) {
            return _.filter(specs, spec => {
                return spec.is_reviewed < 1;
            });
        },

        getCustomerSpecsForReviewCount(specs) {
            return _.size( this.getCustomerSpecsForReview(specs) );
        },

        getPagination() {
            var pagination_url = laroute.route('api.search.external');
            this.fetchData(pagination_url);
        },

        setModalSpec(spec,action) {
            this.modalConfirmation.category = spec;
            this.modalConfirmation.action = action;
        },

        modalAction() {
            this.modalConfirmation.action === "update"
                ? this.updateSpecStatus()
                : this.removeSpec();
        },

        setUpdateSpec(specRevision) {
            this.indexOfSpecForUpdate = specRevision;
        },

        updateSpecStatus() {
            var update_status = laroute.route("external.revision.update", {external:this.modalConfirmation.category.id});

            this.$http.patch(update_status, {is_reviewed: 1,revision:this.indexOfSpecForUpdate.revision})
                .then(
                    () => this.delete(this.modalConfirmation.category.customer_spec_revision, this.indexOfSpecForUpdate),
                    () => this.errorDialogMessage()
                );
        },

        removeSpec() {
            var route_delete = laroute.route("external.destroy", {external:this.modalConfirmation.category.id});
            this.destroyData(route_delete);
        },
    }
});