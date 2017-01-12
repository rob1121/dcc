require("./app");
import { toUpper, capitalize } from "./modules/stringformatter";
import { telfordStandardDate } from "./modules/dateFormatter";

const app = new Vue( {
    el: "#app",

    data:
    {
        selected: [],
        pagination: esd,
        searchKey: ""
    },

    computed: {
        documents() {
            return _.filter(
                this.pagination, (o) => o.name.toLowerCase().includes(this.searchKey.toLowerCase())
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
        setModalSpec(esd)
        {
            this.selected = esd;
        },

        removeESD()
        {
            var route_delete = laroute.route("esd.destroy", {esd:this.selected.id});

            this.$http.delete(route_delete).then(
                () => this.delete(this.selected),
                () => this.errorDialogMessage()
            );
        },

        delete(esd)
        {
            var index = this.pagination.indexOf(esd);
            this.pagination.splice(index, 1);
        },
    }
} );