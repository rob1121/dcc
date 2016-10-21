require('./app');
import abstract from "./mixins/abstract";

const app = new Vue( {
    el: "#app",

	mixins: [abstract],

	data: {
    	pagination: {}
	},

	mounted() {
		this.getPagination();
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
        remove(user)
        {
            const delete_route = laroute.route("user.destroy", {user: user.id});
            this.$http.delete(delete_route).then(
                () => this.deleteItem(this.pagination.data, user),
                error => console.log(error.text())
            );
        },

        deleteItem(collection, item)
        {
            var index = collection.indexOf(item);
            collection.splice(index, 1)
        },

        getPagination(num = null)
        {
            this.fetchData(laroute.route("api.search.user"), num, '');
        }
    }
} );