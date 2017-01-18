require("./app");
import { toUpper, capitalize } from "./modules/stringformatter";
import { telfordStandardDate } from "./modules/dateFormatter";

const app = new Vue( {
    el: "#app",

    data:
    {
        pagination: {},
        selectedIso: [],
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
    created() {
        this.$http.get(laroute.route("iso.all"))
            .then(({data})=> this.pagination = data);
    },

    filters: {
        toUpper,
        capitalize,
        telfordStandardDate
    },

    methods:
    {
        setModalSpec(iso)
        {
            this.selectedIso = iso;
        },

        removeIso()
        {
            var route_delete = laroute.route("iso.destroy", {iso:this.selectedIso.id});

            this.$http.delete(route_delete).then(
                () => this.delete(this.selectedIso),
                () => this.errorDialogMessage()
            );
        },

        delete(iso)
        {
            var index = this.pagination.indexOf(iso);
            this.pagination.splice(index, 1);
        },
    }
} );