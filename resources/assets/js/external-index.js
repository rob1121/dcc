require("./app");
import abstract from "./mixins/abstract";

const app = new Vue({
	el: "#app",

	data: {
		category: {
			customer_name: category.customer_name
		},

		modalConfirmation: {
		    action: "update",
			category: [],
            indexOfSpecForUpdate: null
		},

        pagination: {}
	},

    mixins: [abstract],

    filters: {
	    filterReduceMap(customer) {
           return _.reduce(this.pagination.data , (total, item) => {
               if(item.customer_spec_category.customer_name === customer) {
                   for(var x in item.customer_spec_revision) {
                       if(item.customer_spec_revision[x].is_reviewed === 0) total++;
                   }
               }
               return total;
            },0);
        },
    },

    computed: {
        customerSpecForReview() {
            return this.getCustomerSpecsForReview(
                this.modalConfirmation.category.customer_spec_revision
            );
        }
    },

    methods: {

        externalRouteFor(specRevision) {
            return laroute.route('external.show', {external:specRevision.customer_spec_id,revision:specRevision.revision});
        },

        getCustomerSpecsForReview(specs) {
            return _.filter(specs, spec => {
                return spec.is_reviewed;
            });
        },

        getCustomerSpecsForReviewCount(specs) {
            return _.size( this.getCustomerSpecsForReview(specs) );
        },

        getPagination(num = "") {
            var pagination_url = laroute.route('api.search.external');
            this.fetchData(pagination_url, num, this.category.customer_name);
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