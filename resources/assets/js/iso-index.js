require("./app");
import search from "./mixins/search";
import filter from "./mixins/filterMethods";

const app = new Vue( {
    el: "#app",

    data:
    {
        pagination: isos,

        selectedIso: []
    },

    mixins:[search, filter],

    methods:
    {
        getLatestRevision(revArray, column) {
            return typeof revArray[revArray.length-1][column] !== undefined
                ? revArray[revArray.length-1][column]
                : "N/A";
        },

        internalRouteFor(id)
        {
            return laroute.route('internal.show', {internal: id});
        },

        externalRouteFor(id)
        {
            return laroute.route('external.show', {external: id});
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