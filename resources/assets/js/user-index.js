require('./app');

const app = new Vue( {
    el: "#app",

	data: {
    	pagination: {}
	},

	mounted() {
		this.getUsers();
	},

    filters: {
    	capitalize(string)
    	{
    		return _.toUpper(string);
    	},

    	nameCase(name)
    	{
    		return _.map( name.split(" ") , (word) => _.capitalize(word) ).join(" ");
    	}
    },

	methods: {
		editRouteFor(id) {
			return laroute.route("user.edit", {user: id});
		},

    	getUsers()
		{
    		return this.$http.get(laroute.route("api.search.user"))
				.then(response => this.pagination = response.json());
		},

    	deleteUser(user)
		{
    		this.$http.delete(user.route);
		}
	}
} );