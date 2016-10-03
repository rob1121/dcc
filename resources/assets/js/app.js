
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
window.laroute = require('./laroute');
import * as vFilter from "./mixins/filters";
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

Vue.component('dcc-input', require('./components/Input.vue'));
Vue.component('dcc-textarea', require('./components/Textarea.vue'));
Vue.component('dcc-button', require('./components/Button.vue'));
Vue.component('dcc-datepicker', require('./components/Datepicker.vue'));
Vue.component('dcc-modal', require('./components/Modal.vue'));
Vue.component('dcc-pulse', require('./components/PulseLoader.vue'));

Vue.filter('trim', vFilter.trim);
Vue.filter('count', vFilter.count);
Vue.filter('latestRevision', vFilter.latestRevision);
Vue.filter('telfordStandardDate', vFilter.telfordStandardDate);
Vue.filter('internalRoute', vFilter.internalRoute);
Vue.filter('externalRoute', vFilter.externalRoute);
Vue.filter('isNewRevision', vFilter.isNewRevision);


const nav = new Vue({
    el: 'nav',

    data: {
        showResultDialog: false,
        searchKeyword: "",
        searchResults: []
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

        errorDialogMessage: function () {
            return alert("Oops, server error!. Try refreshing your browser. \n \n if this message box keeps on coming contact system administrator");
        },

        toggleSearchResult() {
            this.showResultDialog = true;
        },

        closeResultDialog() {
            this.showResultDialog =false;
            this.searchResults = [];
            this.searchKeyword = "";
        }
    }
});
