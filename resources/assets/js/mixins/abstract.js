import search from "./search";

export default {

	mounted() {
		this.$nextTick( () => this.getPagination() )
	},

	mixins: [search],

	methods: {
		fetchData(pagination_url, category) {
			this.$http.get(pagination_url, {
				params: { category: category }
			}).then(
				response => {
					this.setPagination(response.json())
				},
				() => this.errorDialogMessage()
			);
		},

		destroyData(route_delete) {
			this.$http.delete(route_delete)
				.then(
					() => this.delete(this.pagination, this.modalConfirmation.category),
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

		errorDialogMessage() {
			return alert("Oops, server error!. Try refreshing your browser. \n \n if this message box keeps on coming contact system administrator");
		},
	}
}