require("./app");
import search from "./mixins/search";

const app = new Vue({
    el: "#app",

    data: {
        isos,

        selectedIso: []
    },

    mixins:[search],

    filters: {
        isoRoute(id) {
            return laroute.route('iso.show', {iso:id});
        },

        routeEditLink(id) {
            return laroute.route("iso.edit", {iso:id});
        }
    },

    methods: {
        setModalSpec(iso) {
            this.selectedIso = iso;
        },

        errorDialogMessage() {
            return alert("Oops, server error!. Try refreshing your browser. \n \n if this message box keeps on coming contact system administrator");
        },

        removeIso() {
            var route_delete = laroute.route("iso.destroy", {iso:this.selectedIso.id});

            this.$http.delete(route_delete)
                .then( () => this.isos.$remove(this.selectedIso),
                       () => this.errorDialogMessage() );
        }
    }
});