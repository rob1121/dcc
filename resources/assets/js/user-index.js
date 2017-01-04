require('./app');
import { searchKey, searchCategoryKey, activeCategory, setActiveCategory, setSearchCategoryKey, emptySearchKey } from "./modules/SidebarModules";
import { modalConfirmation, setModalSpec } from "./modules/modalConfirmationModule";
import { toUpper, capitalize } from "./modules/stringformatter";

const app = new Vue( {
    el: "#app",

	data: {
		modalConfirmation,
    	pagination: {},
		keyword: "",
		sort: {
    		key: "employee_id",
			in: true
		},
        searchKey,
        searchCategoryKey,
        activeCategory,
        navToggler: false
	},

	mounted() {
		this.getUsers();
	},

	computed: {
        documentsByCategory() {
            let document = this.pagination;

            if (this.searchCategoryKey === null && this.pagination.length > 0)
                this.searchCategoryKey = this.pagination[0].user_type;

            if(this.searchCategoryKey !== "")
                document = _.filter(this.pagination, (o) => {
                    return o.user_type.toLowerCase() === this.searchCategoryKey.toLowerCase();
                });

            return document;
        },

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
    	},
    },

	methods: {
        setActiveCategory,
        setSearchCategoryKey,
        emptySearchKey,
        setModalSpec,
    	filterUser()
        {
            return this.searchKey === ""
                ? this.documentsByCategory
			    : _.filter(this.pagination, (o) => {
                    return o.name.toLowerCase().includes(this.searchKey.toLowerCase())
                        || o.employee_id.toLowerCase().includes(this.searchKey.toLowerCase())
                        || o.department.toLowerCase().includes(this.searchKey.toLowerCase())
                        || o.user_type.toLowerCase().includes(this.searchKey.toLowerCase())
                        || o.email.toLowerCase().includes(this.searchKey.toLowerCase());
                });
		},

		sortColumn(key)
        {
			this.sort.in  = this.sort.key === key ? ! this.sort.in : this.sort.in;
			this.sort.key = key;
		},

		setModalUser(user)
        {
			this.modalConfirmation.category = user;
		},

		removeUser()
		{
		    const user = this.modalConfirmation.category;
		    const delete_route = laroute.route("user.delete", { user: user.id });

		    this.$http.delete(delete_route).then(
                () 	  => this.deleteItem(this.pagination, user),
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
                error 	 => console.log(error)
            );
		}
	}
} );