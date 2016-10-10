import search from "./search";
import filter from "./filterMethods";

export default {

	mounted() {
		this.$nextTick( () => this.getPagination() )
	},

	mixins: [search, filter],

	methods: {
		fetchData(pagination_url, num, category) {
			this.$http.get(pagination_url, {
				params: { page:num, category: category }
			}).then(
				(response) => this.setPagination(response.json()),
				() => this.errorDialogMessage()
			);
		},

		destroyData(route_delete) {
			this.$http.delete(route_delete)
				.then(
					() => this.delete(this.pagination.data, this.modalConfirmation.category),
					() => this.errorDialogMessage()
				);
		},
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

		delete(collection, spec) {
			var index = collection.indexOf(spec);
			collection.splice(index, 1)
		},

		prev() {
			this.getPagination(this.pagination.current_page - 1);
		},

		next() {
			this.getPagination(this.pagination.current_page + 1);
		},

		errorDialogMessage() {
			return alert("Oops, server error!. Try refreshing your browser. \n \n if this message box keeps on coming contact system administrator");
		},

		internalRouteFor(id) {
			return laroute.route('internal.show', {internal: id});
		},

		internalEditRouteFor(id) {
			return laroute.route("internal.edit", {internal:id});
		},

		externalRouteFor(id) {
			return laroute.route('external.show', {external: id});
		},


		externalEditRouteFor(id) {
			return laroute.route("external.edit", {external:id});
		},

		getLatestRevision(revArray, column) {
			return typeof revArray[revArray.length-1][column] !== undefined
				? revArray[revArray.length-1][column]
				: "N/A";
		},
	}
}