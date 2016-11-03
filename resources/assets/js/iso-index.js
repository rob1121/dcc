require("./app");
import { toUpper, capitalize } from "./modules/stringformatter";
import { telfordStandardDate } from "./modules/dateFormatter";

const app = new Vue( {
    el: "#app",

    data:
    {
        pagination: isos,
        selectedIso: [],
        searchKey: ""
    },

    computed: {
      documents() {
          return _.filter(this.pagination, (o) => o.name.toLowerCase().includes(this.searchKey.toLowerCase()));
      }
    },

    filters: {
        toUpper,
        capitalize,
        telfordStandardDate
    },

    methods:
    {
        getLatestRevision(revArray, column) {
            return typeof revArray[revArray.length-1][column] !== undefined
                ? revArray[revArray.length-1][column]
                : "N/A";
        },

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

        showRouteFor(id)
        {
            return laroute.route('iso.show', {iso:id});
        },

        editRouteFor(id)
        {
            return laroute.route("iso.edit", {iso:id});
        }
    }
} );