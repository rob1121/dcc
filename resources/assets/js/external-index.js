require("./app");

const app = new Vue({
	el: "#app",

	data: {
		category: {
			customer_name
		},

		modalDeleteConfirmation: {
			category: [],
			index: -1
		},

        specForReviewModal: [],

		currentIndex: 0,

		pagination: [],
	},

	ready() {
		this.getPagination();
	},

    filters: {
        documentLink(specRevision) {
            return laroute.route('external.show', {external:specRevision.customer_spec_id,revision:specRevision.revision});
        },

        count(collection) {
            return collection.length;
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

            var pagination_url = laroute.route('api.search.external');
            this.$http.get(pagination_url, {
                params: { page:num, category:this.category.customer_name }
            })
                .then( response => {
                    this.pagination = response.json();
                    loader.hide();
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

        setModalSpec(spec, index = -1) {
            this.modalDeleteConfirmation.category = spec;
            this.modalDeleteConfirmation.index = index;
        },

        setSpecForReviewModal(spec) {
            this.specForReviewModal = spec;
        },

        resetModalData() {
            this.setModalSpec({});
        },

        removeSpec() {
            var route_delete = laroute.route("external.destroy", {external:this.modalDeleteConfirmation.category.id});
            this.$http.delete(route_delete)
                .then( () => {
                    this.pagination.data.$remove(this.modalDeleteConfirmation.category);
                    this.resetModalData();
                }, () => this.removeSpec());
        },
    }
});