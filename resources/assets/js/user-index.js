require('./app');
import { toUpper, capitalize } from "./modules/stringformatter";

const app = new Vue( {
    el: "#app",

	data: {
    	pagination: {},
		keyword: "",
		sort: {
    		key: "employee_id",
			in: true
		},
		searchKey: ""
	},

	mounted() {
		this.getUsers();
	},

	computed: {

		users() {
			const filter = this.filterUser();

			return _.orderBy(filter,[this.sort.key], [this.sort.in ? "asc" : "desc"]);
		}
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
    	filterUser() {
			return _.filter(this.pagination, (o) => {
				return o.name.toLowerCase().includes(this.searchKey.toLowerCase())
					|| o.employee_id.toLowerCase().includes(this.searchKey.toLowerCase())
					|| o.department.toLowerCase().includes(this.searchKey.toLowerCase())
					|| o.user_type.toLowerCase().includes(this.searchKey.toLowerCase())
					|| o.email.toLowerCase().includes(this.searchKey.toLowerCase());
			});
		},

		sortColumn(key) {
			this.sort.in = this.sort.key === key ? ! this.sort.in : this.sort.in;
			this.sort.key = key;
		},

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