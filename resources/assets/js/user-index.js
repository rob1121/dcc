require('./app');
import { toUpper, capitalize } from "./modules/stringformatter";
import { search } from "./modules/search";

const app = new Vue( {
    el: "#app",

	data: {
    	pagination: {},
		keyword: ""
	},

	mounted() {
		this.getUsers();
	},

    filters: {
		capitalize,
        toUpper,
    	nameCase(name)
    	{
    		return _.map( name.split(" ") , (word) => _.capitalize(word) ).join(" ");
    	}
    },

	methods: {
        search,
        clearSearch() {
			this.search('users', 'all');
			this.keyword = "";
        },
		remove(user)
		{
		    const delete_route = laroute.route("user.destroy", {user: user.id});
		    this.$http.delete(delete_route).then(
                () => this.deleteItem(this.pagination, user),
                error => console.log(error.text())
            );
		},

        deleteItem(collection, item)
        {
            var index = collection.indexOf(item);
            collection.splice(index, 1)
        },

    	getUsers()
		{
    		return this.$http.get(laroute.route("api.search.user")).then(
				response => this.pagination = response.json(),
                error => console.log(error)
            );
		}
	}
} );