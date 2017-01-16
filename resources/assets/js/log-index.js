require("./app");
import { toUpper, capitalize } from "./modules/stringformatter";
import { telfordStandardDate } from "./modules/dateFormatter";

const app = new Vue( {
    el: "#app",

    data:
    {
        selected: [],
        pagination: {},
        searchKey: ""
    },

    created(){
        console.log(laroute.route('log.all'));
        
        this.$http.get(laroute.route('log.all')).then(
            ({data}) => {
                this.pagination = JSON.parse(data);
            });
    },

    computed: {
        documents() {
            return _.filter(
                this.pagination,
                (o) => o.name.toLowerCase().includes(this.searchKey.toLowerCase())
                    || o.spec_no.toLowerCase().includes(this.searchKey.toLowerCase())
            );
        }
    },

    filters: {
        toUpper,
        capitalize,
        telfordStandardDate
    },

    methods:
    {
        setModalSpec(log)
        {
            this.selected = log;
        },

        removeLog()
        {
            var route_delete = laroute.route("log.destroy", {log:this.selected.id});

            this.$http.delete(route_delete).then(
                () => this.delete(this.selected),
                () => this.errorDialogMessage()
            );
        },

        delete(log)
        {
            var index = this.pagination.indexOf(log);
            this.pagination.splice(index, 1);
        },

        alertDemo(demo) {
            alert(demo);
        }
    }
} );