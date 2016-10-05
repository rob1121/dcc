export default {
    data() {
        return {
            showResultDialog: false,
            searchKeyword: "",
            searchResults: []
        }
    },

    computed: {
        isSearchResultNotEmpty() {
            return this.searchResults.internal && this.searchResults.external;
        },
    },

    methods: {
        displaySearchResult() {

            var search_route = laroute.route("search");
            this.$http.get(search_route, {
                params: { q: this.searchKeyword}
            }).then(
                response => { this.searchResults = response.json(); this.toggleSearchResult(); },
                () => this.errorDialogMessage()
            );
        },

        errorDialogMessage() {
            return alert("Oops, server error!. Try refreshing your browser. \n \n if this message box keeps on coming contact system administrator");
        },

        toggleSearchResult() {
            this.showResultDialog = true;
        },

        closeResultDialog() {
            this.showResultDialog =false;
            this.searchResults = [];
            this.searchKeyword = "";
        },

        clearSearchInput() {
            this.closeResultDialog();
        }
    }
}