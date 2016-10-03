require("./app");

const app = new Vue({
    el: "#app",

    data: {
        isos,

        selectedIso: []
    },

    filters: {
        isoRoute(id) {
            return laroute.route('iso.show', {iso:id});
        },

        routeEditLink(id) {
            return laroute.route("iso.edit", {iso:id});
        }
    },

    methods: {
        toggleButton() {
            var btn = $('.toggler-btn');

            btn.children('i').toggleClass("fa-bars");
            btn.children('i').toggleClass("fa-remove");
        },

        showSideBar() {
            $('#sidebar').toggleClass("show-sidebar");
            $('.main-content').toggleClass("compress-main-content");

            this.toggleButton();
        },

        setModalSpec(iso) {
            this.selectedIso = iso;
        },

        errorDialogMessage: function () {
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